<?php

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
    ->state(
        [
'title' => 'Course Title'
        ])
    ->create();
    //Acف  && Assert
    Livewire::test(ShowCourse::class,['course' => $course])
    ->assertOk()
    ->assertSeeText('Course Title')
    ->assertSeeText($course->tagline)
    ->assertSeeText($course->description);

});
