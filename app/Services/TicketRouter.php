<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;

class TicketRouter
{
    public function routeTicket(Ticket $ticket)
    {
        $assignedAgent = $this->findSuitableAgent($ticket);
        if ($assignedAgent) {
            $ticket->assignTo($assignedAgent);
            return true;
        }
        return false;
    }

    private function findSuitableAgent(Ticket $ticket)
    {
        return User::where('role', 'agent')
            ->orderBy('active_tickets_count', 'asc')
            ->first();
    }
}
