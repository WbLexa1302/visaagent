<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action; // <-- 1. IMPORT TERPASANG DI SINI

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Menampilkan Foto Cover Mini
                ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->circular(), // Membuat foto berbentuk bulat rapi

                // 2. Menampilkan Judul Post
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable() // Kolom ini bisa dicari lewat fitur search
                    ->sortable()
                    ->wrap(), // Agar teks panjang otomatis turun ke bawah

                // 3. Menampilkan Slug
                TextColumn::make('slug')
                    ->label('Slug/URL')
                    ->toggleable(isToggledHiddenByDefault: true), // Disembunyikan default, bisa dimunculkan jika mau

                // 4. Menampilkan Status Publish (Menggunakan Icon Centang/Silang)
                IconColumn::make('is_published')
                    ->label('Status Publish')
                    ->boolean() // Otomatis mengubah true jadi centang hijau, false jadi silang merah
                    ->sortable(),

                // 5. Menampilkan Jumlah Viewer (Koneksi ke Analytics Post kamu)
                TextColumn::make('views')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable()
                    ->default(0),

                // 6. Menampilkan Tanggal Dibuat
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Kamu bisa menambah filter status publish di sini nanti
            ])
            ->actions([
                EditAction::make(),

                // --- 2. TOMBOL "LIHAT ARTIKEL" DISISIPKAN DI SINI ---
                ActionsAction::make('view_public')
                    ->label('Lihat Artikel')
                    ->icon('heroicon-o-eye') // Menggunakan ikon mata
                    ->color('success')       // Berwarna hijau agar kontras
                    ->url(fn (\App\Models\Post $record): string => route('posts.show', $record->slug))
                    ->openUrlInNewTab(),     // Membuka halaman di tab baru browser

                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
