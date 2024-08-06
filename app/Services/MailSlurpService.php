<?php

// app/Services/MailSlurpService.php

namespace App\Services;

use MailSlurp\Api\InboxControllerApi;
use MailSlurp\Api\MailServerControllerApi;
use MailSlurp\Configuration;

class MailSlurpService
{
    protected $inboxController;
    protected $mailServerController;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('x-api-key', env('MAILSLURP_API_KEY'));
        $this->inboxController = new InboxControllerApi(null, $config);
        $this->mailServerController = new MailServerControllerApi(null, $config);
    }

    public function createInbox()
    {
        return $this->inboxController->createInbox();
    }

    public function getEmails($inboxId)
    {
        return $this->mailServerController->getEmails($inboxId);
    }
}

