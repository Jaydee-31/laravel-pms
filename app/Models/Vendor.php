<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'contact_info',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
