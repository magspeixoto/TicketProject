<?php

namespace App\Console\Commands;

use App\Services\MailSlurpService;
use Illuminate\Console\Command;

class CreateMailSlurpWebhook extends Command
{
    protected $signature = 'mailslurp:create-webhook';
    protected $description = 'Create a webhook for MailSlurp';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mailSlurpService = new MailSlurpService();
        $inboxId = '7f45df38-631a-4843-bde0-3f41c0939246'; // Substitua pelo ID da sua caixa de entrada
        $webhookUrl = 'https://deac-109-50-169-188.ngrok-free.app/webhook'; // Substitua pela URL do ngrok

        try {
            $response = $mailSlurpService->createWebhook($inboxId, $webhookUrl);
            $this->info('Webhook created successfully:');
            $this->line(json_encode($response, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            $this->error('Error creating webhook:');
            $this->line($e->getMessage());
        }
    }
}
