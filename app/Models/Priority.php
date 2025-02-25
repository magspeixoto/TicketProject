<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function slas()
    {
        return $this->belongsToMany(Sla::class, 'sla_priority');
    }
}
