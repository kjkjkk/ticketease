<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketNature extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_nature_name',
        'status',
    ];
}
