<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'academy_id',
    'name',
    'description',
    'start_date',
    'end_date',
    'capacity'
])]
class Course extends Model
{
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)
                    ->withPivot('enrolled_at');
    }
}