<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    // Define the relationship to WorkflowStatuses
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // Define the relationship to Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
