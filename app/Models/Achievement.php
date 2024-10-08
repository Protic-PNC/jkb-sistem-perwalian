<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id'
    ];

    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'class_id');
    }

    public function achievement_detail()
    {
        return $this->hasMany(AchievementDetail::class, 'achievement_id', 'achievement_id');
    }
}
