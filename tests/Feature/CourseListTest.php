<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Course;
use Livewire\Livewire;
use App\Models\Episode;
use App\Livewire\CourseList;
use Illuminate\Database\Eloquent\Factories\Sequence;


it('renders successfully', function () {
    $course= Course::factory(3)
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory()->state(['length_in_minutes' => 10]),'episodes')
    ->create();


    Livewire::test(CourseList::class)
        ->assertStatus(200);

    });

    it('show a list of all Courses', function () {
        $course= Course::factory(3)
        ->state(new Sequence(
            ['title'=> 'Course A'],
            ['title'=> 'Course B'],
            ['title'=> 'Course C'],

        ))
        ->for(User::factory()->instructor() ,'instructor')
        ->has(Episode::factory()->state(['length_in_minutes' => 10]),'episodes')
        ->create();



        Livewire::test(CourseList::class)
            ->assertSeeText(
                 'Course A',
                'Course B',

            );

        });


it('shows the course tags',function () {
    $course= Course::factory()
    ->for(User::factory()->instructor() ,'instructor')
    ->has(Episode::factory())
    ->has(Tag::factory()
    ->count(2)
    ->state(new Sequence(
        ['name'=>'Tailwind'],
        ['name'=>'Mysql'],
    ))
)

    ->create(); 

    $user=User::factory()->create();
    $user->courses()->attach($course);

    Livewire::actingAs($user)->test(CourseList::class,['course'=>$course])
    ->assertOk()
    ->assertSeeText([
        'Tailwind',
        'Mysql'
    ]);

});


