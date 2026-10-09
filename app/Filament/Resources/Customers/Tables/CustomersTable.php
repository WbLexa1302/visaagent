<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction; // <-- Diperbaiki dari Filament\Actions ke Filament\Tables\Actions
use Filament\Tables\Actions\BulkActionGroup; // <-- Diperbaiki dari Filament\Actions ke Filament\Tables\Actions
use Filament\Tables\Actions\DeleteBulkAction; // <-- Diperbaiki dari Filament\Actions ke Filament\Tables\Actions

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('passport_number')
                    ->label('No. Passport')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Telepon'),

                TextColumn::make('nationality')
                    ->label('Kewarganegaraan')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Place your filters here
            ])
            ->actions([
                ActionsEditAction::make(),
            ])
            ->bulkActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}
