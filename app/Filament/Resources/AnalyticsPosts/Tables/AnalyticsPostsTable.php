<?php

namespace App\Filament\Resources\AnalyticsPosts\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class AnalyticsPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Judul Post')
                    ->searchable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unique_visitors')
                    ->label('Unique Visitors'),

                Tables\Columns\TextColumn::make('average_read_time')
                    ->label('Avg Time (Min)')
                    ->suffix(' min'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(), // Tidak perlu Tables\Actions\ lagi
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
