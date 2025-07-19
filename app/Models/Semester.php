<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester',
        'start_year',
        'end_year',
    ];

    /**
     * A semester belongs to a student (user).
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * A semester has many courses.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}