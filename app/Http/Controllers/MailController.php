<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('MailController invoked');

        // Capturar o conteúdo bruto da solicitação para depuração
        $rawContent = $request->getContent();
        Log::info('Raw request content', ['content' => $rawContent]);

        // Converter para UTF-8 se necessário
        if (!mb_detect_encoding($rawContent, 'UTF-8', true)) {
            $rawContent = mb_convert_encoding($rawContent, 'UTF-8', 'auto');
            Log::info('Content converted to UTF-8');
        }

        // Decodificar o JSON da solicitação
        $data = json_decode($rawContent, true);

        // Verificar erros de decodificação JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON decoding error: ' . json_last_error_msg());
            return response()->json(['error' => 'Invalid JSON'], 400);
        }

        // Adicionar log para verificar a estrutura decodificada
        Log::info('Decoded request content', ['data' => $data]);

        // Extraindo os dados do JSON
        $subject = $data['subject'] ?? null;
        $from = $data['from'] ?? null;
        $bodyPlain = $data['body-plain'] ?? null;

        // Certifique-se de que todos os dados estejam em UTF-8
        $subject = utf8_encode($subject);
        $from = utf8_encode($from);
        $bodyPlain = utf8_encode($bodyPlain);

        Log::info('Email received', ['subject' => $subject, 'from' => $from, 'body' => $bodyPlain]);

        // Verificar se os dados essenciais estão presentes
        if (!$subject || !$from || !$bodyPlain) {
            Log::error('Missing data: subject, from, or body-plain is null');
            return response()->json(['error' => 'Missing data'], 400);
        }

        // Extraindo o endereço de e-mail do remetente
        preg_match('/<(.*?)>/', $from, $matches);
        $email = $matches[1] ?? $from;

        Log::info('Parsed email', ['email' => $email]);

        // Verificar se o email foi extraído corretamente
        if (!$email) {
            Log::error('Email address not parsed correctly');
            return response()->noContent();
        }

        // Encontrar o usuário pelo endereço de e-mail ou criar um novo usuário
        try {
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $email,
                'password' => bcrypt('password'), // Defina uma senha padrão segura
            ]);

            Log::info('User found or created', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Error creating or finding user', ['message' => $e->getMessage()]);
            return response()->noContent();
        }

        // Criar um novo ticket
        try {
            $ticket = Ticket::create([
                'subject' => $subject,
                'description' => $bodyPlain,
                'category_id' => 1, // Defina uma categoria padrão ou extraia do e-mail
                'user_id' => $user->id,
                'status' => 'open',
                'priority' => 'medium',
            ]);

            Log::info('Ticket created', ['ticket_id' => $ticket->id]);
        } catch (\Exception $e) {
            Log::error('Error creating ticket', ['message' => $e->getMessage()]);
            return response()->noContent();
        }

        return response()->noContent();
    }
}
