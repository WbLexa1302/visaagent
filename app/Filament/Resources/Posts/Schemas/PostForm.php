<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input Gambar Cover
                FileUpload::make('cover_image')
                    ->label('Cover Image')
                    ->image()
                    ->disk('public') // Memastikan tersimpan di disk public
                    ->directory('posts-covers')
                    ->visibility('public') // <-- Tambahkan ini
                    ->columnSpanFull(),

                // Input Judul
                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    // Otomatis membuat slug ketika judul diisi
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) =>
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    ),

                // Input Slug/URL
                TextInput::make('slug')
                    ->label('Slug / URL')
                    ->disabled() // Dimatikan agar diisi otomatis oleh sistem
                    ->dehydrated() // Tetap disimpan ke database walau disabled
                    ->required()
                    ->unique(ignoreRecord: true),

                // Input Konten Artikel (Menggunakan Rich Editor/WYSIWYG)
                RichEditor::make('content')
                    ->label('Isi Artikel')
                    ->required()
                    ->columnSpanFull(),

                // Status Publish
                Toggle::make('is_published')
                    ->label('Publish Artikel Sekarang?')
                    ->default(false),
            ]);
    }
}
