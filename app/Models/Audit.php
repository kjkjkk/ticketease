<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'activity',
        'previous_status_id',
        'new_status_id',
    ];

    public function previousStatus()
    {
        return $this->belongsTo(Status::class, 'previous_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(Status::class, 'new_status_id');
    }
}
