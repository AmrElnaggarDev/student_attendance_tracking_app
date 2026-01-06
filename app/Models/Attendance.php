<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'grade_id',
        'date',
        'status',
        'reason',
        'note_type',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function getNoteColorAttribute() {
        return match($this->note_type) {
            'medical' => 'bg-blue-100 text-blue-800',
            'behavioral' => 'bg-purple-100 text-purple-800',
            'general' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }


    public function student () :BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function grade () :BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }


}
