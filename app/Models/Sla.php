<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'response_time', 'resolution_time'];

    public function priorities()
    {
        return $this->belongsToMany(Priority::class, 'sla_priority');
    }
}
