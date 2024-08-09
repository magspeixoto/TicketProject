<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MailSlurp\Apis\InboxControllerApi;

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
        // Validate the inboxId as a UUID
        if (!filter_var($inboxId, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/"]])) {
            throw new \InvalidArgumentException("Invalid UUID for inboxId");
        }

        $webhookUrl = route('mailslurp.webhook');

        // Replace 'your_api_key' with your actual MailSlurp key
        $apiKey = env('MAILSLURP_API_KEY');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey
        ])->post("https://api.mailslurp.com/inboxes/{$inboxId}/webhooks", [
            'url' => $webhookUrl,
        ]);

        // Log the response for debugging
        Log::info('Webhook setup response: ' . $response->body());

        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['id'])) {
                return response()->json(['webhookId' => $responseData['id']]);
            } else {
                Log::error('Error setting up webhook: Undefined array key "id"');
                return response()->json(['error' => 'Failed to set up webhook'], 500);
            }
        } else {
            Log::error('Failed to set up webhook: ' . $response->body());
            return response()->json(['error' => 'Failed to set up webhook'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error setting up webhook: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to set up webhook'], 500);
    }
}

    public function handleEmailWebhook(Request $request)
    {
        // Handle the incoming email webhook
        // Example: Create a new ticket based on the email content
        $email = $request->input('email');
        $subject = $email['subject'];
        $body = $email['body'];

        // Create a new ticket
        $ticket = new Ticket();
        $ticket->subject = $subject;
        $ticket->body = $body;
        $ticket->save();

        return response()->json(['message' => 'Webhook handled successfully']);
    }
}
