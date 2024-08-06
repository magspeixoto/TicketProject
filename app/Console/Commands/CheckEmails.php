<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MailSlurpService;
use App\Models\Ticket;

class CheckEmails extends Command
{
    protected $signature = 'emails:check';
    protected $description = 'Check for new emails and create tickets';

    protected $mailSlurpService;

    public function __construct(MailSlurpService $mailSlurpService)
    {
        parent::__construct();
        $this->mailSlurpService = $mailSlurpService;
    }

    public function handle()
    {
        $inboxId = '108366f2-11f5-4092-bc24-1b6fb948a28f';

        $emails = $this->mailSlurpService->getEmails($inboxId);

        foreach ($emails as $email) {
            Ticket::updateOrCreate(
                ['subject' => $email->getSubject()],
                [
                    'body' => $email->getBody(),
                    'from' => $email->getFrom()
                ]
            );
        }

        $this->info('Checked for new emails and updated tickets.');
    }
}
