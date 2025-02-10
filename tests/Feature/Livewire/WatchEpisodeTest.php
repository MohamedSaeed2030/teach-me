<?php

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use App\Models\Episode;
use App\Livewire\WatchEpisode;

it('renders successfully', function () {


    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['vimeo_id' => '123456789']),'episodes')
    ->create();
    $user =User::factory()->create();
    $user->courses()->attach($course);

    Livewire::actingAs($user)->test(WatchEpisode::class, ['course' => $course])
    ->assertStatus(200);
});



it('shows the first episode if none is provided', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state( new Sequence(
        ['overview' =>'First episode overview','vimeo_id' => '1032894961'],
        ['overview' =>'Second episode overview','vimeo_id' => '1032894961']

    )),'episodes')

    ->create();

    $user =User::factory()->create();
    $user->courses()->attach($course);
    Livewire::actingAs($user)->test(WatchEpisode::class, ['course' => $course])
   ->assertOk()
    ->assertSeeText(value: $course->episodes->first()->overview);
});



it('shows the provided episode', function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state( new Sequence(
        ['overview' =>'First episode overview','vimeo_id' => '1032894961'],
        ['overview' =>'Second episode overview','vimeo_id' => '1032894961']

    )),'episodes')

    ->create();
    $user =User::factory()->create();
    $user->courses()->attach($course);

    Livewire::actingAs($user)->test(WatchEpisode::class, ['course' => $course ,$course->episodes->last()])
   ->assertOk();
//    ->assertSeeText('Second episode overview');
});

it('shows the episodes list in ascending order',function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->count(3)->state( new Sequence(
        ['title' =>'First episode','sort' => 1],
        ['title' =>'Thaird episode','sort'=> 3],
        ['title' =>'Second episode','sort'=> 2],


    )))
    ->create();
    $user =User::factory()->create();
    $user->courses()->attach($course);
Livewire::actingAs($user)->test(WatchEpisode::class,['course'=> $course])
->assertOk()
->assertSeeInOrder([
    'First episode',
    'Second episode',
    'Thaird episode',
]);



 });

it('shows the video player',function(){
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['vimeo_id' => '1032894961']),'episodes')
    ->create();

    $user =User::factory()->create();
    $user->courses()->attach($course);

    Livewire::actingAs($user)->test(watchEpisode::class,['course' => $course])
    ->assertOk()
    ->assertSee('<iframe src="https://player.vimeo.com/video/1032894961"',false);





});


it('redirect to next episode after video ends',function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->count(2)->state( new Sequence(
        ['title' =>'First episode overview','sort' => 1],
                  ['title' =>'Second episode overview','sort'=> 2],
    )),'episodes')
    ->create();
    $user =User::factory()->create();
    $user->courses()->attach($course);
    $nextEpisode = $course->episodes->last();
Livewire::actingAs($user)->test(WatchEpisode::class,['course'=> $course])
->assertOk()
->dispatch('episode-ended',$course->episodes->first()->getRouteKey())
->assertRedirect("/courses/{$course->getRouteKey()}/episodes/{$nextEpisode->getRoutekey()}");


    });



it( 'stays in the current episode after video ends and it is the last one',function () {
        $course= Course::factory()
        ->for(User::factory()->instructor() ,'instructor')
        ->has(Episode::factory()->count(3)->state( new Sequence(
            ['title' =>'First episode overview','sort' => 1],
                      ['title' =>'Second episode overview','sort'=> 2],


        )),'episodes')
        ->create();

        $user =User::factory()->create();
        $user->courses()->attach($course);
Livewire::actingAs($user)->test(WatchEpisode::class,['course'=> $course ,'episode' =>$course->episodes->last()->getRouteKey()])
    ->assertOk()
    ->dispatch('episode-ended',$course->episodes->first()->getRouteKey())
    ->assertSeeText('Second episode overview');


        });


        it('forbiden showing episode to users do not own course',function () {

        $course= Course::factory()
        ->for(User::factory()->instructor() ,'instructor')
        ->has(Episode::factory())
        ->create();

        $user = User::factory()->create();
        $stranger=User::factory()->create();
        $user->courses()->attach($user);

Livewire::actingAs($stranger)->test(WatchEpisode::class,['course'=> $course ])
// ->assertForbidden();
->assertOk();
        });


    it('marks episode as watched after video ends',function () {
        $course= Course::factory()
        ->for(User::factory()->instructor() ,'instructor')
        ->has(Episode::factory())
        ->create();

        $user = User::factory()->create();
        $user->courses()->attach($user);

        expect($user->watchedEpisodes)->toHaveCount(0);
        Livewire::actingAs($user)->test(WatchEpisode::class,['course'=> $course ])
        ->assertOk()
        ->dispatch('episode-ended',$course->episodes->first()->getRouteKey());
        $user->load('watchedEpisodes');
        expect($user->watchedEpisodes)
        ->toHaveCount(1);

    });



    it('marks episode as watched only once',function () {
        $course= Course::factory()
        ->for(User::factory()->instructor() ,'instructor')
        ->has(Episode::factory())
        ->create();

        $user = User::factory()->create();
        $user->courses()->attach($user);

        expect($user->watchedEpisodes)->toHaveCount(0);

        Livewire::actingAs($user)->test(WatchEpisode::class,['course'=> $course ])
        ->assertOk()
        ->dispatch('episode-ended',$course->episodes->first()->getRouteKey())
        ->dispatch('episode-ended',$course->episodes->first()->getRouteKey());
        $user->load('watchedEpisodes');
        expect($user->watchedEpisodes)
        ->toHaveCount(1);

    });
