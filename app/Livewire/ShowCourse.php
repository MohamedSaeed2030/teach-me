<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Episode;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;

use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class ShowCourse extends Component implements  HasInfolists ,HasForms
{

    use InteractsWithForms, InteractsWithInfolists;

    public Course $course;

public function mount(Course $course){
$this->course = $course;
$this->course->loadCount( 'episodes');


// dump($this->course->formatted_length);
// dump($this->course->title);

// dd($course->episodes->first()->title);


}


    public function courseInfolists(Infolist $infolist): Infolist
    {
        return $infolist
        ->record($this->course)
            ->schema([
                  Section::make()
                 ->schema([
                    TextEntry::make('title')
                    ->alignCenter()
                    ->label('')
                    ->size('text-4xl')
                    ->weight('font-serif')
                    ->columnSpanFull(),
                    TextEntry::make('tagline')
                    ->label('')
                    ->columnSpanFull(),
                    // TextEntry::make('description')
                    // ,
                    TextEntry::make('instructor.name')
                    ->label('Teacher Name')
                    ->columnSpanFull(),



                    Fieldset::make('')
                    ->columns(4 )
                    ->columnSpan(1)
                    ->schema(
                        [
                            TextEntry::make('episodes_count')
                            ->label('')
                            ->icon('heroicon-o-film')
                            ->formatStateUsing(fn ($state) => "$state episodes"),

                            TextEntry::make('formatted_length')
                            ->label('')
                            ->icon('heroicon-o-clock')
                            ,
                            TextEntry::make('created_at')
                            ->label('')
                            // ->date(format: 'M d, Y')
                            ->formatStateUsing(fn ($state) => $state->diffForHumans())
                            ->icon('heroicon-o-calendar'),
                        ]
                    )
                    ->extraAttributes(['class'=> 'border-none !p-0'])
                ])
                ->columns(2),
                Section::make('About this course')
                // ->description(fn(Course $record) => $record->description)

                ->columns(3)
                ->schema([
                    TextEntry::make('description')
                    ->columnSpan(2),

                   RepeatableEntry::make('episodes')

                    ->schema([
                        TextEntry::make('title')
                        ->label('')
                        ->icon('heroicon-o-play-circle')
                        ->url(fn(Episode $record)=>route('courses.episodes.show',['course'=>$record->course->getRouteKey() ,'episode' =>$record->getRouteKey() ])),
                        TextEntry::make('formatted_length')
                        ->label('')
                        ->icon('heroicon-o-clock')
                    ])
                    ->columns(2)

                ])

            ]);

    }

    public function render()
    {
        return view('livewire.show-course');
    }
}

