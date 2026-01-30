<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'assigned_to',
        'status',
        'user_id',
    ];

    // Task statuses
    public const STATUSES  = [
        'backlog',
        'ToDo',
        'In Progress',
        'QA',
        'shared for UAT',
        'Done',
        'Reject',
    ];

    // Task belongs to a user (creator)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Task assigned to a user
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
