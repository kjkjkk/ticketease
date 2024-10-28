<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComplete extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_assign_id',
    ];
}
