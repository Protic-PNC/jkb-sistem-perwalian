<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'program_id';

    protected $fillable = [
        'program_name',
        'degree',
        'head_of_program_id',
    ];

    public function head_of_program()
    {
        return $this->belongsTo(Lecturer::class, 'head_of_program_id', 'lecturer_id');
    }

    public function classes()
    {
        return $this->hasMany(StudentClass::class, 'program_id', 'program_id');
    }
}
