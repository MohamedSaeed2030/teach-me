<?php

namespace App\Livewire;


use App\Models\Course;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CourseList extends Component implements HasForms, HasTable
{
    use InteractsWithForms,InteractsWithTable;

    public Collection $courses;
    public function mount(Collection $courses)
    {
        $this->courses = Course::all();
    }


    public function table(Table $table)
    {
        return $table
        ->query(Course::query()->withCount('episodes'))
        ->contentGrid([
            'md'=>2,
            'lg'=>3,
        ])
        ->columns([
            Stack::make([
                TextColumn::make('tags.name')
                ->badge(),
                TextColumn::make('title')
                ->color('gray-100')
                ->size('text-xl')
                ->weight('font-bold'),
                TextColumn::make('tagline')
                ->size('text-[0.5]')
                ->color('gray'),
                Split::make([
                    TextColumn::make('episodes_count')
                    ->formatStateUsing(fn ($state)=> $state.' '.Str::plural('episod',$state))
                    ->size('text-[0.7rem]')
                    ->color('gray')
                    ->icon('heroicon-o-film')
                    ,
                    TextColumn::make('formatted_length')
                    ->size('text-[0.7rem]')
                    ->color('gray')
                    ->icon('heroicon-o-clock'),





                ])

            ])->space(3)


                ])
                ->actions([
                    Action::make('Start Watching')
                        ->url(fn (Course $record) => route('courses.show', ['course' => $record]))
                        ->button()
                        ->extraAttributes([
                            // 'class' => 'mx-auto my-8',
                            'class'=>"w-full bg-blue-400"
                        ])
                        ->icon('heroicon-s-play-circle')
                        ->modalAlignment('center'), // If the Alignment::Center constant exists, use it; otherwise, 'center'
                ]);
    }
//     protected function paginateTableQuery(Builder $query): Paginator
// {
//     return $query->simplePaginate(($this->getTableRecordsPerPage() === 'all') ? $query->count() : $this->getTableRecordsPerPage());
// }

    public function render()
    {
        return view('livewire.course-list');
    }
}
