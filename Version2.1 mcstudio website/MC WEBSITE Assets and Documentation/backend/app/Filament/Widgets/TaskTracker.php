<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProjectResource;
use Closure;
use App\Models\Project;
use App\Models\ProjectTask;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TaskTracker extends BaseWidget
{
    // protected static string $view = 'filament.widgets.task-tracker';

    public static ?string $heading = 'Project Tasks Overview';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 8;
    

    // protected function getViewData(): array
    // {
    //     $projects = Project::all();

    //     $upcomingTasks = $projects->flatMap(function($project){
    //         return $project->tasks->filter(function($task){
    //                     return $task->due_date->diffInHours(now()) <= (5 * 24);
    //                 }); 
    //     });

    //     return [$upcomingTasks];
    // }

    protected function getTableQuery(): Builder
    {
        // return ProjectTask::where(function($q){
        //     $q->where('due_date', '<=', now()->addHours(5 * 24));
        // })->orWhere(function($q){
        //     $q->where('due_date', '<=', now())->whereIn('status', ['new', 'inprogress']);
        // });
        return ProjectTask::query();
    }
 
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('project.number')
                ->label('Project Id')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('started_at')
                ->label('Start Date')
                ->date('M d, Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('due_date')->date('M d, Y')
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('upcoming')
                ->query(function(Builder $query): Builder{
                    return $query->where('due_date', '<=', now()->addHours(5 * 24))
                                ->orWhere(function($q){
                                    $q->where('due_date', '<=', now())->whereIn('status', ['new', 'inprogress']);
                                });
                })
                ->default(),
            Filter::make('past_due')
                ->query(fn (Builder $query): Builder => $query->where([['due_date','<=', now()],['status',['new', 'inprogress']]]))  
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $record): string => ProjectResource::getUrl('edit', ['record' => $record->project],false);
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('Admin') && Project::count();
    }
}
