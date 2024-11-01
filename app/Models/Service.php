<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    public function fields(): HasMany
    {
        return $this->hasMany(ServiceField::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps();
    }
}
