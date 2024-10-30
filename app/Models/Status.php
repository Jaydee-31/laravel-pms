<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['workflow_id', 'name', 'position', 'is_final'];

    // Define the relationship to Workflow
    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    // Define the relationship to Tasks as the current status
    public function tasks()
    {
        return $this->hasMany(Task::class, 'current_status_id');
    }
}
