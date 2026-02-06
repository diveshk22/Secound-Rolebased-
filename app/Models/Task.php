<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
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
        return $this->belongsTo(User::class, 'assigned_to'); //column name check kar
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Task has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }
}
