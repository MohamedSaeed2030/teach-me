<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;


    protected $fillable = ['title','taglin','description'];



    public function instructor()
    {
        return $this->belongsTo(User::class,'instructor_id');
    }
}
