<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceField extends Model
{
    protected $fillable = [
        'service_id',
        'field_name',
        'field_type',
        'field_options',
        'is_required',
    ];

    protected $casts = [
        'field_options' => 'json',
        'is_required' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps();
    }

    public function briefings()
    {
        return $this->hasMany(Briefing::class);
    }
}
