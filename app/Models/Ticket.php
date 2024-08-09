<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'category_id',
        'user_id',
        'agent_id',
        'status',
        'sla_id',
        'priority_id',
        'priority',
        'assigned_to'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function assignTo(User $user)
    {
        $this->assigned_to = $user->id;
        $this->save();
    }
    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected static function booted()
    {
        static::created(function ($ticket) {
            self::routeTicket($ticket);
        });
    }

    //ticket Routing without criteria
    protected static function routeTicket($ticket)
    {
        $agent = self::findAvailableAgent();
        if ($agent) {
            $ticket->agent_id = $agent->id;
            $ticket->save();

        } else {
            Log::warning("No available agents to assign the ticket.");
        }
    }

    protected static function findAvailableAgent()
    {
        return User::where('role', 'agent')
            ->inRandomOrder()
            ->first();
    }

    public function sla()
    {
        return $this->belongsTo(Sla::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function getResponseDueTimeAttribute()
    {
        return $this->created_at->addMinutes($this->sla->response_time);
    }

    public function getResolutionDueTimeAttribute()
    {
        return $this->created_at->addMinutes($this->sla->resolution_time);
    }
}
