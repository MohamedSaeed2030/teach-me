<?php

namespace Database\Seeders;
use App\Models\Tag;
use App\Models\User;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $course= Course::factory()
            ->state([
                "title"=> "Laravel Bootcamp",
                "tagline" => "Start Creating Your Laravel Project With Filament and LiveWire",
                "description"=> "Voluptatibus velit omnis aut quam sint consequuntur. Fuga aut repudiandae officia occaecati sed. Excepturi cumque doloremque animi non consequuntur accusantium libero.",
            ])
            ->for(User::factory()->state([
                "name"=> "Instructor",
                "email"=> "instructor#example.com"
                ])->instructor() ,'instructor')
                ->has(Episode::factory(3)->state( new Sequence(

                    [
                    'title'=> 'introduction',
                    'overview'=> 'Voluptatibus velit omnis aut quam sint consequuntur. Fuga aut repudiandae officia occaecati sed. Excepturi cumque doloremque animi non consequuntur accusantium libero.',
                    'vimeo_id'=>'1032897220',
                    'length_in_minutes'=>3,
                    'sort'=> 1,

                    ],

                    [
                    'title'=> 'Mohamed SAid',
                    'overview'=> 'Voluptatibus velit omnis aut quam sint consequuntur. Fuga aut repudiandae officia occaecati sed. Excepturi cumque doloremque animi non consequuntur accusantium libero.',
                    'vimeo_id'=>'1032897220',
                    'length_in_minutes'=>2,
                    'sort'=> 1,

                    ],
                    [

                    'title'=> 'Ali Mohamed',
                    'overview'=> 'Voluptatibus velit omnis aut quam sint consequuntur. Fuga aut repudiandae officia occaecati sed. Excepturi cumque doloremque animi non consequuntur accusantium libero.',
                    'vimeo_id'=>'1032894961',
                    'length_in_minutes'=>9,
                    'sort'=> 1,

                    ],

                )),'episodes')
                ->has(Tag::factory()
                ->count(2)
                ->state(new Sequence(
                    ['name'=>'Laravel'],
                    ['name'=>'Filament'],
                ))
            )
                ->create();

      $user=  User::factory()->create([
            'name' => 'Mohamed Said',
            'email' => 'test@example.com',
        ]);

        $user->courses()->attach($course);
    }
}
