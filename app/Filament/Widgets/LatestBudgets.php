<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BudgetResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBudgets extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                BudgetResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Servicio')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->sortable(),

                Tables\Columns\TextColumn::make('latestStatus.status_label')
                    ->label('Status')
                    ->color(fn ($state, $record) => match ($record->latestStatus?->status) {
                        1 => 'primary',    // Aberto
                        5 => 'success',    // Aprovado
                        3 => 'warning',    // Pendiente
                        4 => 'danger',     // Rechazado
                        6 => 'secondary',  // En proceso
                        7 => 'gray',       // Finalizado
                        2 => 'info',       // Enviado
                        default => 'gray', // Cor padrão caso não corresponda a nenhum status
                    })
                    ->formatStateUsing(fn ($state, $record) => $record->latestStatus?->status_label ?? 'Unknown'),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}