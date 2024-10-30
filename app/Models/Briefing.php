<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Briefing extends Model
{
    protected $fillable = [
        'task_id',
        'service_id',
        'service_field_id',
        'value',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function serviceField()
    {
        return $this->belongsTo(ServiceField::class);
    }
}
