<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'semester_id',
        'course_name',
        'units',
        'grade',
        'remarks',
    ];

    public function semesters()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
