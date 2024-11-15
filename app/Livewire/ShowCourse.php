<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class ShowCourse extends Component
{


    public Course $course;
    public function render()
    {
        return view('livewire.show-course');
    }
}
