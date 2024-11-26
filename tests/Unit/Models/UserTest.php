<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Collection;

it('Has Many Courses', function () {

    $user = User::factory()->create();
    $course =Course::factory()
        ->for(User::factory()->instructor(),'instructor')
        ->create();
        $user->courses()->attach($course);
        expect($user->courses)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(Course::class)
        ->first()->title->toBe($course->title);

});

it('Has Many Watched episodes', function () {

    $user = User::factory()->create();
    $course =Course::factory()
        ->for(User::factory()->instructor(),'instructor')
        ->create();
        $user->courses()->attach($course);
        $episode = Episode::factory()->for($course)->create();
        $user->watchedEpisodes()->attach($episode);


        expect($user->watchedEpisodes)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(Episode::class)
        ->first()->title->toBe($episode->title);

});


 
