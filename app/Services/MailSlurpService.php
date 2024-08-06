<?php

namespace App\Services;

use MailSlurp\Configuration;
use MailSlurp\Api\InboxControllerApi;
use MailSlurp\ApiClient;
use MailSlurp\Model\InboxDto;
use MailSlurp\Model\EmailDto;

class MailSlurpService
{
    protected $inboxApi;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('apiKey', config('mailslurp.api_key'));

        $client = new ApiClient($config);
        $this->inboxApi = new InboxControllerApi($client);
    }

    public function getInbox()
    {
        $inboxes = $this->inboxApi->getInboxes();
        return $inboxes[0];
    }

    public function getEmails($inboxId)
    {
        $emails = $this->inboxApi->getEmails($inboxId);
        return $emails;
    }
}
