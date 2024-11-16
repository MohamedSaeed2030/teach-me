<?php

use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use App\Livewire\ShowCourse;

it('renders successfully', function () {
    Livewire::test(ShowCourse::class)
        ->assertStatus(200);

    });


it('shows course details',function (){
    //Arrange
   $course= Course::factory()
   ->for(User::factory()->instructor() ,'instructor')

   ->create();


    //Acف  && Assert
    Livewire::test(ShowCourse::class,['course' => $course])
    ->assertOk()
    ->assertSeeText($course->title)
    ->assertSeeText($course->tagline)
    ->assertSeeText($course->description)
    ->assertSeeText($course->instructor->name)
    ->assertSeeText('Nov 16, 2024');

});

