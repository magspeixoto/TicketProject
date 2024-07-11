<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateTicketMailbox extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        try {
            // Find or create user based on email
            $user = User::firstOrCreate(
                ['email' => $this->email->from[0]['address']],
                ['name' => $this->email->from[0]['name'] ?? $this->email->from[0]['address'], 'password' => bcrypt(str_random(16))]
            );

            // Create a new ticket
            $ticket = Ticket::create([
                'title' => $this->email->subject,
                'description' => $this->email->text ?? $this->email->html,
                'status' => 'open',
                'user_id' => $user->id,
                'priority' => 'medium', // Set default priority
            ]);

            // Handle attachments if needed
            if (!empty($this->email->attachments)) {
                foreach ($this->email->attachments as $attachment) {
                    $path = $attachment->store('attachments');
                    $ticket->attachments()->create([
                        'path' => $path,
                        'name' => $attachment->getClientOriginalName(),
                    ]);
                }
            }

            Log::info('Ticket created successfully from email', ['ticket_id' => $ticket->id]);
        } catch (\Exception $e) {
            Log::error('Error creating ticket from email', ['error' => $e->getMessage()]);
        }

        return $this;
    }
}
