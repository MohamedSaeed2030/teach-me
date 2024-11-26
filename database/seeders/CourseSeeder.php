<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory()
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
                ->create();

    }
}
