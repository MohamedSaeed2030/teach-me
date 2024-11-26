<?php

use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use App\Models\Episode;
use App\Livewire\ShowCourse;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('renders successfully', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['length_in_minutes' => 10])->count(10),'episodes')
    ->create();
    Livewire::test(ShowCourse::class,['course'=>$course])
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
    ->assertSeeText($course->created_at->diffForHumans())
    ->assertSeeText($course->episodes_count . ' episodes')
    ->assertSeeText($course->formatrd_length)
    ;

});

it('shows the episode list',function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->count(3)->state( new Sequence(
        ['title' =>'First episode','length_in_minutes' => '5'],
        ['title' =>'Second episode','length_in_minutes' => '10'],
        ['title' =>'Thaird episode','length_in_minutes' => '1'],

    )))
    ->create();

Livewire::test(ShowCourse::class,['course'=> $course])
->assertOk()
->assertSeeText('First episode')
->assertSeeText('5 mins')
->assertSeeText('Second episode')
->assertSeeText('10 mins')
->assertSeeText('Thaird episode')
->assertSeeText('1 min');




});
