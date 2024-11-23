<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    /** @use HasFactory<\Database\Factories\EpisodeFactory> */
    use HasFactory;

    protected $fillable = [ 'title' ,'length_in_minutes'];



    public function course(){
        return $this->belongsTo(Course::class);
    }



    protected function formattedLength(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                $hours = floor($attributes['length_in_minutes']/ 60);
                $hoursString = $hours > 0 ? $hours . ' ' . Str::plural('hr', $hours) . ' ': '';
                $remainderMinutes = $attributes['length_in_minutes'] % 60;
                $minutesString = $remainderMinutes . ' ' . Str::plural('mins', $remainderMinutes);
                return $hoursString . $minutesString ;
            }
        );
    }



}
