<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchMailHogEmails extends Command
{
    protected $signature = 'fetch:mailhog';
    protected $description = 'Fetch emails from MailHog and convert them into tickets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client(['base_uri' => 'http://localhost:8025']);

        $response = $client->get('/api/v2/messages');
        $emails = json_decode($response->getBody()->getContents(), true);

        foreach ($emails['items'] as $email) {
            $this->createTicketFromEmail($email);
            $this->deleteEmail($client, $email['ID']);
        }

        $this->info('Emails fetched and tickets created successfully.');
    }

    protected function createTicketFromEmail($email)
    {
        $rawContent = $email['Raw']['Data'];
        $emailDetails = $this->parseEmail($rawContent);

        // Create a new ticket in your application
        Ticket::create([
            Ticket::create([
                'subject' => $emailDetails['subject'],
                'description' => substr($emailDetails['body'], 0, 255), // Adjust length if necessary
                'email' => $emailDetails['from'],
                'name' => $emailDetails['name'],
                'category_id' => 1, // Provide a default category_id or fetch dynamically
                'user_id' => 1, // Provide a default category_id or fetch dynamically
            ])
        ]);
    }

    protected function parseEmail($rawContent)
    {
        $headers = [];
        $body = '';
        $isBody = false;
        foreach (explode("\n", $rawContent) as $line) {
            if ($isBody) {
                $body .= $line . "\n";
            } elseif (trim($line) === '') {
                $isBody = true;
            } else {
                list($key, $value) = explode(':', $line, 2);
                $headers[trim($key)] = trim($value);
            }
        }

        return [
            'from' => $headers['From'],
            'subject' => $headers['Subject'],
            'body' => $body,
            'name' => $headers['From'], // Simplified, adjust as needed
        ];
    }

    protected function deleteEmail($client, $id)
    {
        $client->delete("/api/v1/messages/{$id}");
    }
}
