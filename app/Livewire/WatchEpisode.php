<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Episode;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Infolists\Components\VideoPlayerEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class WatchEpisode extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists, InteractsWithForms;

    public Course $course;
    public Episode $currentEpisode;
    public function mount(Course $course, Episode $episode)
    {
        $this->course = $course;
        if(isset($episode->id))
       { $this->currentEpisode=$episode;}
        else
        {  $this->currentEpisode =$course->episodes->first();}


    }


    public function episodeInfoList(Infolist $infolist)
    {
        return $infolist
        ->record($this->currentEpisode)
        ->columns(3)
        ->schema([
            Section::make([
                TextEntry::make("title")
                ->hiddenLabel()
                ->size('text-4xl')
                ->weight('font-bold')
                ->columnSpan(2),
                VideoPlayerEntry::make('vimeo_id')
                ->hiddenLabel()
                ->columnSpan(2),

                TextEntry::make("overview")
                ->columnSpan(2),



            ])
            ->columnSpan (2),
            RepeatableEntry::make('course.episodes')
            ->hiddenLabel()
            ->schema([
                TextEntry::make('title')
                ->hiddenLabel()
                ->icon('heroicon-o-play-circle')
                ->url(fn(Episode $record)=>route('courses.episodes.show',['course'=>$record->course->getRouteKey() ,'episode' =>$record->getRouteKey() ])),

                TextEntry::make('formatted_length')
                ->hiddenLabel()
                ->icon('heroicon-o-clock'),


            ])
            ->columns(2)

        ]);



    }
    public function render()
    {
        return view('livewire.watch-episode');

    }
}
