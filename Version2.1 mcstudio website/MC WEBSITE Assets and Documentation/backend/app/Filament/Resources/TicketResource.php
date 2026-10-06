<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use Filament\Tables;
use Filament\Resources\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Sgcomptech\FilamentTicketing\Filament\Resources\TicketResource as BaseTicketResource;

class TicketResource extends BaseTicketResource
{

    protected static ?string $label = 'Support Tickets';

    public static function table(Table $table): Table
    {
        $user = auth()->user();
        if (config('filament-ticketing.use_authorization')) {
            $canManageAllTickets = $user->can('manageAllTickets', Ticket::class);
            $canManageAssignedTickets = $user->can('manageAssignedTickets', Ticket::class);
        } else {
            $canManageAllTickets = true;
            $canManageAssignedTickets = true;
        }

        $statuses = array_map(fn ($e) => __($e), config('filament-ticketing.statuses'));
        $priorities = array_map(fn ($e) => __($e), config('filament-ticketing.priorities'));

        return $table
            ->columns([
                TextColumn::make('identifier')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('Ticket for')
                    ->formatStateUsing(fn ($record) => "[".(new \ReflectionClass($record->ticketable))->getShortName()."] ".$record->ticketable->number),
                TextColumn::make('user.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->translateLabel()
                    ->searchable()
                    ->words(8),
                TextColumn::make('status')
                    ->translateLabel()
                    ->formatStateUsing(fn ($record) => $statuses[$record->status] ?? '-'),
                TextColumn::make('priority')
                    ->translateLabel()
                    ->formatStateUsing(fn ($record) => $priorities[$record->priority] ?? '-')
                    ->color(fn ($record) => $record->priorityColor()),
                TextColumn::make('assigned_to.name')
                    ->translateLabel()
                    ->visible($canManageAllTickets || $canManageAssignedTickets),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn($record) => $record->created_at->format('D, M Y H:i:s'))
            ])
            ->filters([
                Filter::make('filters')
                    ->form([
                        Select::make('status')
                            ->translateLabel()
                            ->options($statuses),
                        Select::make('priority')
                            ->translateLabel()
                            ->options($priorities),
                    ])
                    ->query(
                        fn (Builder $query, array $data) => $query
                        ->when($data['status'], fn ($query, $status) => $query->where('status', $status))
                        ->when($data['priority'], fn ($query, $priority) => $query->where('priority', $priority))
                    ),
            ])
            ->actions([
                // ViewAction::make(),
                EditAction::make()
                    ->visible($canManageAllTickets || $canManageAssignedTickets),
            ])
            ->bulkActions([
                // DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderByDesc('created_at');
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
