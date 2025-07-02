<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'course_name',
        'units',
        'grade',
        'remarks',
    ];

    /**
     * A course belongs to a semester.
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
