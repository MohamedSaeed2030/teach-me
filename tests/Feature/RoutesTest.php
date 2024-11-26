<?php

use App\Models\User;

use App\Models\Course;
use App\Models\Episode;
use function Pest\Laravel\get;

it('It Has A Route For The Course Details Page', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->create();




    get(route('courses.show', ['course' =>$course]))
    ->assertOk();
});


it('It Has A Route For The WatchEpisode  Page with optional parameter', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['vimeo_id' => '123456789']),'episodes')
    ->create();




    get(route('courses.episodes.show', ['course' =>$course ,'episode' => $course->episodes->first()]))
    ->assertOk();

    get(route('courses.show', ['course' =>$course]))
    ->assertOk();

});
