<?php

// app/Services/MailSlurpService.php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class MailSlurpService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.mailslurp.com/',
            'headers' => [
                'Authorization' => 'Bearer fb24cebd860d10483b1226d8895d23fdd25aa33d0b2c7b7b8a67553cb86baa65',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createWebhook($inboxId, $url)
    {
        try {
            $response = $this->client->post('webhooks', [
                'json' => [
                    'name' => 'New Ticket Webhook',
                    'inboxId' => $inboxId,
                    'url' => $url,
                    'eventName' => 'EMAIL_RECEIVED'
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorBody = $errorResponse ? (string)$errorResponse->getBody() : 'No response body';
            throw new \Exception("Error creating webhook: " . $errorBody);
        }
    }
}

