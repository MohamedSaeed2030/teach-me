<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\Section;

use Filament\Forms\Concerns\InteractsWithForms;

class ShowCourse extends Component implements  HasInfolists ,HasForms
{

    use InteractsWithForms, InteractsWithInfolists;

    public Course $course;

public function mount(Course $course){

$this->course = $course;

}


    public function courseInfolists(Infolist $infolist): Infolist
    {
        return $infolist
        ->record($this->course)
            ->schema([
                  Section::make()
                 ->schema([

                    TextEntry::make('title'),
                    TextEntry::make('tagline'),
                    TextEntry::make('description'),
                    TextEntry::make('instructor.name'),
                    TextEntry::make('created_at')
                    ->date('M d, Y'),


                ])



            ]);
    }

    public function render()
    {
        return view('livewire.show-course');
    }
}

