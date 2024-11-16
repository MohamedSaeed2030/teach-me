<?php

use App\Models\User;
use App\Models\Course;

test('has an instructor relationship', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->create();

    expect($course->instructor)
    ->toBeInstanceOf(User::class)
    ->is_instructor->toBeTrue();
});
