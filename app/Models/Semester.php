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

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'semester_id', 'id');
    }
}
