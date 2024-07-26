<?php

namespace App\Services;

use MailSlurp\Api\InboxControllerApi;
use MailSlurp\Configuration;
use MailSlurp\Models\Email;

class MailSlurpService
{
    protected $inboxApi;

    public function __construct(InboxControllerApi $inboxApi)
    {
        $this->inboxApi = $inboxApi;
    }

    public function getEmails($inboxId)
    {
        return $this->inboxApi->getEmails($inboxId);
    }

    public function processEmails($inboxId)
    {
        $emails = $this->getEmails($inboxId);

        foreach ($emails as $email) {
            $this->createTicketFromEmail($email);
        }
    }

    protected function createTicketFromEmail($email)
    {
        // Implement your ticket creation logic here
    }
}
