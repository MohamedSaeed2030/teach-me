<?php

use App\Models\User;

use App\Models\Course;
use App\Models\Episode;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('It Has A Route For The Course Details Page', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory(),'episodes')
    ->create();

    $user =User::factory()->create();
    $user->courses()->attach($course);

    actingAs($user);
    get(route('courses.show', ['course' =>$course]))
    ->assertOk();
});


it(' Has A Route For The WatchEpisode  Page with optional parameter', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['vimeo_id' => '123456789']),'episodes')
    ->create();

    $user =User::factory()->create();
    $user->courses()->attach($course);
    actingAs($user);

    get(route('courses.episodes.show', ['course' =>$course ,'episode' => $course->episodes->first()]))
    ->assertOk();

    get(route('courses.show', ['course' =>$course]))
    ->assertOk();

});

it('it only shows episodes to authenticated users', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['vimeo_id' => '123456789']),'episodes')
    ->create();

    get(route('courses.episodes.show', ['course' =>$course ]))
    ->assertRedirect(route('login'));

});

it('has a route for course list ', function () {

    get(route('courses.index'))
    ->assertOk();

});
it('has a route for the pricing plans', function () {
    get('pricing')
    ->assertOk();
});

