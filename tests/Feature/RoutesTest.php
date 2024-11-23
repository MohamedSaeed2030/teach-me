<?php

use App\Models\User;

use App\Models\Course;
use function Pest\Laravel\get;

it('It Has A Route For The Course Details Page', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->create();




    get(route('courses.show', ['course' =>$course]))
    ->assertOk();
});


