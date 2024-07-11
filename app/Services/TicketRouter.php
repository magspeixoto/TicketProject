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
        }
    }

    private function findSuitableAgent(Ticket $ticket)
    {
        return User::whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })
            ->where('skills', 'like', '%' . $ticket->category . '%')
            ->orderBy('active_tickets_count', 'asc')
            ->first();
    }
}
