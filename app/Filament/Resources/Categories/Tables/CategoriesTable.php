<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter; // Tambahkan ini untuk filter
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(), // Ditambahkan sortable agar mempermudah sorting nama

                TextColumn::make('slug'),

                // Menampilkan Kategori Induk dalam bentuk Badge
                TextColumn::make('parent.name')
                    ->label('Kategori Induk')
                    ->badge()
                    ->color('info')
                    ->placeholder('Kategori Utama (Root)'), // Jika null/kosong, teks ini yang muncul
            ])
            ->filters([
                // Filter untuk menyaring data berdasarkan Kategori Induk
                SelectFilter::make('parent_id')
                    ->label('Filter Kategori Induk')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
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
