<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MailSlurpService;

class CheckEmails extends Command
{
    protected $signature = 'emails:check';
    protected $description = 'Check emails using MailSlurp';

    protected $mailSlurpService;

    public function __construct(MailSlurpService $mailSlurpService)
    {
        parent::__construct();
        $this->mailSlurpService = $mailSlurpService;
    }

    public function handle()
    {
        $inbox = $this->mailSlurpService->createInbox();
        $this->info('Inbox created: ' . $inbox->getId());

        $emails = $this->mailSlurpService->getEmails($inbox->getId());
        $this->info('Emails: ' . json_encode($emails));
    }
}
