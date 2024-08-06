<?php

namespace App\Services;

use MailSlurp\ApiClient;
use MailSlurp\Configuration;
use MailSlurp\Api\InboxControllerApi;
use MailSlurp\Configuration as MailSlurpConfig;
use MailSlurp\Model\InboxDto;

class MailSlurpService
{
    protected $client;
    protected $inboxApi;

    public function __construct()
    {
        $config = MailSlurpConfig::getDefaultConfiguration()
            ->setApiKey('apiKey', config('mailslurp.api_key'));

        $this->client = new ApiClient($config);
        $this->inboxApi = new InboxControllerApi($this->client);
    }

    public function getInbox()
    {
        return $this->inboxApi->getInbox();
    }

    public function getEmails()
    {
        // Add implementation to get emails
    }

    // Other MailSlurp related methods...
}
