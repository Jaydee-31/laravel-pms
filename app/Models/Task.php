<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'parent_task_id',
        'workflow_id',
        'status_id',
        'name',
        'description',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    // Define the relationship to current status
    public function currentStatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Define the self-referential relationship for subtasks
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    // Define the inverse relationship to the parent task
    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    public function briefings()
    {
        return $this->hasMany(Briefing::class);
    }
}
