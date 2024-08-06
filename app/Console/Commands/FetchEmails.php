<?php
// app/Console/Commands/ProcessEmails.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MailSlurpService;
use App\Models\Ticket;

class ProcessEmails extends Command
{
    protected $signature = 'emails:process';
    protected $description = 'Fetch emails and create tickets';

    protected $mailSlurpService;

    public function __construct(MailSlurpService $mailSlurpService)
    {
        parent::__construct();
        $this->mailSlurpService = $mailSlurpService;
    }

    public function handle()
    {
        $inboxId = env('MAILSLURP_INBOX_ID'); // You should store your inbox ID somewhere
        $emails = $this->mailSlurpService->getEmails($inboxId);

        foreach ($emails as $email) {
            Ticket::create([
                'subject' => $email->subject,
                'content' => $email->body,
                'email' => $email->from,
            ]);
        }

        $this->info('Emails processed successfully.');
    }
}
