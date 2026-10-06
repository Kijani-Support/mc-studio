<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\Product;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Squire\Models\Currency;
use Sgcomptech\FilamentTicketing\Tables\Actions\TicketAction;
use DB;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $slug = 'Projects';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema(static::getFormSchema())
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => fn (?Project $record) => $record === null ? 3 : 2]),
                

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Project $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Project $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Project $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'cancelled',
                        'warning' => 'processing',
                        'success' => fn ($state) => in_array($state, ['inprogress', 'completed']),
                    ]),
                Tables\Columns\TextColumn::make('budget')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expense')
                    ->getStateUsing(function (Model $record){
                        $total = $record->expenses->sum(function($item): float {
                            return (float) ($item->unit_price * $item->qty);
                        });
                        return (float)($total);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Project Date')
                    ->date()
                    ->toggleable(),
                
            ])
            ->filters([
               // Tables\Filters\TrashedFilter::make(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Project from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Project until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                    TicketAction::make('ticket'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ExpensesRelationManager::class,
            RelationManagers\TasksRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Project $record */

        return [
            'User' => optional($record->user)->name,
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user', 'expenses','tasks']);
    }

    

    public static function getFormSchema(?string $section = null): array
    {
        $projects = DB::table('projects')->whereNotNull('created_at')->latest('created_at')->first();
        if($projects){
         $newProjects = ($projects->id) +1;
        }
         else{
             $newProjects = 1;
         }
        return [
            Forms\Components\TextInput::make('number')
                ->default('PR-' . str_pad($newProjects, 8, 0, STR_PAD_LEFT))
                ->disabled()
                ->required(),

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->label('Customer')
                ->required()
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(),

                    Forms\Components\TextInput::make('phone'),
                ])->preload()
                ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                    return $action
                        ->modalHeading('Create customer')
                        ->modalButton('Create customer')
                        ->modalWidth('lg');
                }),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'processing' => 'Processing',
                    'inprogress' => 'In Progress',
                    'completed' => 'Completed',
                ])
                ->default('new')
                ->required(),

            Forms\Components\TextInput::make('budget')
                ->reactive()
                ->afterStateUpdated(function($state, callable $set){
                    if($state)$set('balance', $state);
                }),

            Forms\Components\TextInput::make('balance')
                ->default(0)
                ->disabled(),


            Forms\Components\Select::make('currency')
                ->searchable()
                ->getSearchResultsUsing(fn (string $query) => Currency::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                ->getOptionLabelUsing(fn ($value): ?string => Currency::find($value)?->getAttribute('name'))
                //->default('kes')
                ->required(),
            Forms\Components\MarkdownEditor::make('notes')
                ->columnSpan('full'),
            Forms\Components\Section::make('Attachments')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('media')
                        ->collection('project-images')
                        ->multiple()
                        ->maxFiles(5)
                        ->disableLabel(),
                ])
                ->collapsible(),

        ];
    }
        protected static function getNavigationBadge(): ?string
    {
        return static::$model::where('status', 'new')->count();
    }
}
