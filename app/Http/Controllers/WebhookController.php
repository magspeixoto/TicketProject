<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log do payload recebido
        $payload = $request->input('payload');

        // Verifique se 'payload' está presente e extraia 'email'
        $email = $payload['email'] ?? null;

        // Log detalhado do payload
        Log::info('Webhook received payload:', ['payload' => $payload]);

        // Verifique se os valores estão presentes
        if (!$email || !isset($email['subject']) || !isset($email['body'])) {
            Log::error('Missing email subject or body', ['email' => $email]);
            return response()->json(['status' => 'error', 'message' => 'Missing email subject or body'], 400);
        }

        // Criação do ticket
        $this->createTicketFromEmail($email);

        return response()->json(['status' => 'success']);
    }

    private function createTicketFromEmail($email)
    {
        Ticket::create([
            'title' => $email['subject'] ?? 'No Subject',
            'description' => $email['body'] ?? 'No Description',
            'priority' => 'medium', // Ajuste conforme necessário
            'status' => 'open',
            'category_id' => 1, // Forneça um valor padrão ou ajuste conforme necessário
            'user_id' => 1, // Forneça um valor padrão ou ajuste conforme necessário
        ]);
    }
}
