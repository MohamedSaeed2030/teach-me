<?php

use App\Livewire\ShowCourse;
use Illuminate\Support\Facades\Route;

Route::get('/courses/{course}',ShowCourse::class)->name('courses.show');

Route::get('/', function(){


    return "Hello World";
});
