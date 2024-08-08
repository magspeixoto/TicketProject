<?php

namespace App\Services;

use MailSlurp\Api\InboxControllerApi;
use MailSlurp\Api\EmailControllerApi;
use MailSlurp\Configuration;

class MailSlurpService
{
    protected $inboxController;
    protected $emailController;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('x-api-key', env('MAILSLURP_API_KEY'));
        $this->inboxController = new InboxControllerApi(null, $config);
        $this->emailController = new EmailControllerApi(null, $config);
    }

    public function createInbox()
    {
        return $this->inboxController->createInbox();
    }

    public function getEmails($inboxId)
    {
        return $this->emailController->getEmailsPaginated($inboxId, 0, 10);
    }
}
