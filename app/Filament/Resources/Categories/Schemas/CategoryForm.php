<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Schemas\Schema; // Menggunakan Form sebagai kontrak standar Filament

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, $set) {
                        /**
                         * Hanya update slug secara otomatis jika sedang dalam mode 'create'.
                         * Ini mencegah slug berubah secara tidak sengaja saat mengedit kategori lama
                         * yang bisa merusak SEO/Link yang sudah tersebar.
                         */
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug (Otomatis)')
                    ->required()
                    // ignoreRecord: true memastikan validasi unik mengabaikan data diri sendiri saat edit
                    ->unique(ignoreRecord: true)
                    // Memastikan data tetap dikirim ke database saat form disubmit
                    ->dehydrated(),

            // Menambahkan Select untuk Kategori Induk (Parent-Child)
            Select::make('parent_id')
                ->label('Kategori Induk (Parent)')
                ->relationship(
                    name: 'parent',
                    titleAttribute: 'name',
                    // Mengabaikan data diri sendiri agar tidak bisa memilih diri sendiri sebagai parent saat edit
                    ignoreRecord: true
                )
                ->placeholder('Pilih jika ini adalah Sub-Kategori')
                ->searchable()
                ->preload(),
            ]);
    }
}
