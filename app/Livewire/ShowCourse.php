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
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;

class ShowCourse extends Component implements  HasInfolists ,HasForms
{

    use InteractsWithForms, InteractsWithInfolists;

    public Course $course;

public function mount(Course $course){
$this->course = $course;
$this->course->loadCount( 'episodes');

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
                    RepeatableEntry::make('episodes')
                    ->schema([
                        TextEntry::make('title')
                        ->label('')
                        ->icon('heroicon-o-play-circle'),
                        TextEntry::make('formatted_length')
                        ->label('')
                        ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2)

                    // ,Fieldset::make('')
                    // ->columns(3)
                    // ->columnSpan(1)
                    // ->schema(
                    //     [

                    //     ]
                    // )
                    // ->extraAttributes(['class'=> 'border-none !p-0'])
                ])
                ->columns(2),

            ]);

    }

    public function render()
    {
        return view('livewire.show-course');
    }
}

