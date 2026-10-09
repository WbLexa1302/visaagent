<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;
// Import Kolom untuk menampilkan data
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            /*
            */
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->circular(), // Biar estetik seperti di web Bali Ease

                TextColumn::make('name')
                    ->label('Nama Visa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visa_type')
                    ->label('Tipe')
                    ->badge(),

                TextColumn::make('price')
                    ->label('Harga Utama')
                    ->money('IDR'),

                // UPDATE KODE DISINI: Menampilkan total jenis ekstensi berbentuk Badge
                TextColumn::make('extension_price')
                    ->label('Layanan Ekstensi')
                    ->state(function ($record) {
                        $count = is_array($record->extension_price) ? count($record->extension_price) : 0;
                        return $count > 0 ? "{$count} Opsi Ekstensi" : 'Tidak Melayani';
                    })
                    ->badge()
                    ->color(fn ($state) => $state === 'Tidak Melayani' ? 'gray' : 'success'),
            ])
            ->filters([
                //
            ])
            /*
               2. ACTIONS: Ini sudah benar, tapi pastikan menggunakan
               namespace Filament\Tables\Actions agar kompatibel dengan tabel.
            */
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}