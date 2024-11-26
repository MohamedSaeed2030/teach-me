<?php

namespace App\Models;

use App\Models\User;
use App\Models\Episode;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('sort');
    }





    // protected function formattedLength(): Attribute{

    //     get: function($value-> array $attributes){


    //         $totalMinutes =$this->episodes->sum('length_in_minutes');
    //         $hours = floor($totalMinutes /60);
    //         $hoursString=$hours > 0 ? ''. Str::plural('hr',$hours) . '' : '';
    //         $reminderMinutes = $totalMinutes %60;
    //         $minutesString=$reminderMinutes .''.Str::plural('min',$reminderMinutes).'';
    //         return "$hoursString $minutesString";
    //     }


    // }


    protected function formattedLength(): Attribute
{
    return Attribute::make(
        get: function ($value, $attributes) {
            if(! isset($this->episodes_sum_length_in_minutes))
            {
                $this->loadSum('episodes','length_in_minutes');
            }
            $totalMinutes = $this->episodes_sum_length_in_minutes;
            $hours = floor($totalMinutes / 60);
            $hoursString = $hours > 0 ? $hours . ' ' . Str::plural('hr', $hours) . ' ': '';
            $remainderMinutes = $totalMinutes % 60;
            $minutesString = $remainderMinutes . ' ' . Str::plural('min', $remainderMinutes);
            return $hoursString . $minutesString ;
        }
    );
}

}
