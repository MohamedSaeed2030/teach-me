<?php

use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use App\Models\Episode;
use App\Livewire\ShowCourse;

it('renders successfully', function () {
    Livewire::test(ShowCourse::class)
        ->assertStatus(200);

    });


it('shows course details',function (){
    //Arrange
   $course= Course::factory()
   ->for(User::factory()->instructor() ,'instructor')
   ->has(Episode::factory()->state(['length_in_minutes' => 10])->count(10),'episodes')
   ->create();

//    dd($course->formatrd_length);

    // && Assert
    Livewire::test(ShowCourse::class,['course' => $course])
    ->assertOk()
    ->assertSeeText($course->title)
    ->assertSeeText($course->tagline)
    ->assertSeeText($course->description)
     ->assertSeeText($course->instructor->name)
    ->assertSeeText($course->created_at->format('M d, Y'))
    ->assertSeeText($course->episodes_count . ' episodes')
    ->assertSeeText($course->formatrd_length)
    ;

});

