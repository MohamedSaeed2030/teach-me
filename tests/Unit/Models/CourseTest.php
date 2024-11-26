<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Collection;

test('belongs to an instructor relationship', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->create();

    expect($course->instructor)
    ->toBeInstanceOf(User::class)
    ->is_instructor->toBeTrue();
});


it('has many episodes', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->count(10))
    ->create();

    expect($course->episodes)
    ->toBeInstanceOf(Collection::class)
    ->toHaveCount(10)
    ->each->toBeInstanceOf(Episode::class);

});


it('has the episodes count', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->count(10))
    ->create();
$course->loadCount('episodes');
expect($course->episodes_count)->toBe(10);

});



it('has the episodes length ', function () {
    $courseA= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['length_in_minutes' => 10])->count(10),'episodes')
    ->create();

    $courseB= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['length_in_minutes' => 5])->count(10),'episodes')
    ->create();

    $courseC= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->create();


expect($courseA->formatted_length)
->toBe('1 hr 40 mins');

expect($courseB->formatted_length)
->toBe('50 mins');

expect($courseC->formatted_length)
->toBe( '0 mins');


});
