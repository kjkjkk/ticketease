<?php

// routes/channels.php
use Illuminate\Support\Facades\Broadcast;
use App\Models\Ticket;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ticket-status.{requestorId}', function ($user, $requestorId) {
    return (int) $user->id === (int) $requestorId;
});


Broadcast::channel('ticket-assign.{technicianId}', function ($user, $technicianId) {
    return (int) $user->id === (int) $technicianId;
});

Broadcast::channel('ticket-reassign.{technicianId}', function ($user, $technicianId) {
    return (int) $user->id === (int) $technicianId;
});


// ---------------ADDDEDDD--------------------

Broadcast::channel('reminder-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('technician-reminder-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('login-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

