<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id',
    'name',
    'description',
    'address',
    'phone',
    'email'
])]
class Academy extends Model
{
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}