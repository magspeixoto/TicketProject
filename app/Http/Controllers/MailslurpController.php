<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use MailSlurp\Apis\InboxControllerApi;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailslurpController extends Controller
{
    protected $inboxController;

    public function __construct(InboxControllerApi $inboxController)
    {
        $this->inboxController = $inboxController;
    }

    public function createInbox()
    {
        $inbox = $this->inboxController->createInbox();
        return response()->json(['inboxId' => $inbox->getId(), 'emailAddress' => $inbox->getEmailAddress()]);
    }

    public function setupWebhook($inboxId)
    {
        try {
            $webhookUrl = route('mailslurp.webhook');
            Log::info('Setting up webhook', ['url' => $webhookUrl, 'inboxId' => $inboxId]);

            $apiKey = env('MAILSLURP_API_KEY');
            $response = Http::withHeaders([
                'x-api-key' => $apiKey
            ])->post("https://api.mailslurp.com/inboxes/{$inboxId}/webhooks", [
                'url' => $webhookUrl,
                'eventName' => 'EMAIL_RECEIVED',
            ]);

            Log::info('Webhook setup response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                $webhookData = $response->json();
                return response()->json(['webhookId' => $webhookData['id']]);
            } else {
                Log::error('Failed to setup webhook', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Failed to setup webhook', 'details' => $response->json()], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception while setting up webhook', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to setup webhook', 'details' => $e->getMessage()], 500);
        }
    }

    public function handleEmailWebhook(Request $request)
    {
        Log::info('Received webhook', ['payload' => $request->all()]);

    $emailData = $request->input('emailDto');

    if (!$emailData) {
        Log::error('No email data received in webhook');
        return response()->json(['error' => 'No email data received'], 400);
    }

    try {
        $ticket = Ticket::create([
            'subject' => $emailData['subject'] ?? 'No Subject',
            'description' => $emailData['body'] ?? $emailData['text'] ?? 'No Content',
            'user_id' => $this->getUserIdFromEmail($emailData['from'] ?? ''),
            'status' => 'open',
            'priority' => 'medium',
            'category_id' => $this->getDefaultCategoryId(),
        ]);

        Log::info('Ticket created from email', ['ticket_id' => $ticket->id]);

        return response()->json(['status' => 'success', 'ticket_id' => $ticket->id]);
    } catch (\Exception $e) {
        Log::error('Failed to create ticket from email', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to process email'], 500);
    }
    }

    private function getUserIdFromEmail($email)
    {
        // Extract email address from the "from" field
        preg_match('/([^<]+@[^>]+)/', $email, $matches);
        $emailAddress = $matches[1] ?? $email;

        // Find or create user based on email address
        $user = User::firstOrCreate(
            ['email' => $emailAddress],
            ['name' => explode('@', $emailAddress)[0]] // Use part before @ as name
        );

        return $user->id;
    }

    private function getDefaultCategoryId()
    {
        // Implement logic to get a default category ID
        // For example, return the ID of a "General" category
        return Category::where('name', 'General')->first()->id ?? null;
    }
}

