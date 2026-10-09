<?php

namespace App\Filament\Resources\Products\Schemas;

// Import namespace yang benar: Filament\Forms
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ProductForm
{
    /**
     * Di Filament v3, kita biasanya menggunakan parameter Form $form
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Section 1: Informasi Dasar (Layout 3 Kolom)
                Section::make('Informasi Dasar Visa')
                    ->description('Detail utama paket visa')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Layanan Visa')
                            ->placeholder('Contoh: B211A Tourist Visa')
                            ->required()
                            ->columnSpan(3), // Penuh sebaris atas

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->placeholder('contoh: b211a-tourist-visa')
                            ->required()
                            ->unique(ignoreRecord: true) // Pastikan slug tidak kembar di database
                            ->columnSpan(3), // Penuh sebaris atas

                        Select::make('category_id')
                            ->relationship('category', 'name') // 'category' adalah nama relasi di Model Product
                            ->required() // Ini wajib agar tidak kena error NOT NULL lagi
                            ->searchable()
                            ->preload(),

                        Select::make('visa_type')
                            ->label('Tipe Visa')
                            ->options([
                                'single_entry' => 'Single Entry',
                                'multiple_entry' => 'Multiple Entry',
                                'kitas' => 'KITAS / Limited Stay',
                            ])
                            ->required(),

                        TextInput::make('price')
                            ->label('Harga Utama')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                    ])->columns(3), // Mengubah layout dasar grid menjadi 3 kolom sejajar

                // Section Baru: Detail Produk (Deskripsi Lengkap)
                Section::make('Detail Produk')
                    ->description('Tambahkan deskripsi lengkap produk visa di sini.')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Deskripsi Produk')
                            ->placeholder('Jelaskan detail produk secara lengkap...')
                            ->columnSpanFull(),
                    ]),

                // Section Baru: Pilihan Layanan Utama (Services)
                Section::make('Pilihan Layanan Utama (Services)')
                    ->description('Tambahkan tipe layanan pengajuan baru seperti Standard, Express, dll.')
                    ->schema([
                        Repeater::make('services')
                            ->label('Daftar Layanan Baru')
                            ->schema([
                                TextInput::make('service_name')
                                    ->label('Nama Layanan')
                                    ->placeholder('Contoh: Express Service')
                                    ->required(),
                                TextInput::make('process_time')
                                    ->label('Waktu Proses')
                                    ->placeholder('Contoh: 3-5 Hari Kerja')
                                    ->required(),
                                TextInput::make('service_price')
                                    ->label('Harga Layanan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->reorderable(true)
                            ->collapsible(),
                    ]),

                // Section Baru: Pilihan Layanan Perpanjangan (Repeater Dinamis)
                Section::make('Pilihan Layanan Ekstensi (Extensions)')
                    ->description('Tambahkan tipe layanan perpanjangan/ekstensi visa di sini (Opsional).')
                    ->schema([
                        Repeater::make('extension_price') // Menghubungkan langsung ke kolom database JSON
                            ->label('Daftar Layanan Ekstensi')
                            ->schema([
                                TextInput::make('ext_name')
                                    ->label('Nama Layanan Ekstensi')
                                    ->placeholder('Contoh: Regular Extension / Express Extension')
                                    ->required(),
                                TextInput::make('ext_process_time')
                                    ->label('Waktu Proses Ekstensi')
                                    ->placeholder('Contoh: 7 Hari Kerja / 2 Hari Kerja')
                                    ->required(),
                                TextInput::make('ext_price')
                                    ->label('Harga Ekstensi')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->reorderable(true)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['ext_name'] ?? null),
                    ]),

                // Section 2: Persyaratan & Durasi
                Section::make('Persyaratan & Durasi')
                    ->schema([
                        TextInput::make('duration')
                            ->label('Masa Berlaku (Hari)')
                            ->placeholder('60')
                            ->numeric()
                            ->suffix('Hari'),

                        TextInput::make('processing_time')
                            ->label('Lama Proses Kerja')
                            ->placeholder('Contoh: 5-7 Business Days'),

                        Textarea::make('requirements')
                            ->label('Dokumen Persyaratan')
                            ->placeholder("1. Scan Passport minimal 6 bulan\n2. Foto Berwarna\n3. Bukti Tabungan")
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(2),

                // Section 3: Media
                Section::make('Media & Ikon')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Utama / Brosur')
                            ->image()
                            ->directory('visa-products')
                            ->imageEditor(),
                        
                        TextInput::make('drive_link')
                            ->label('Google Drive PDF Link')
                            ->placeholder('https://drive.google.com/file/d/.../view')
                            ->url() // Validasi otomatis agar admin wajib memasukkan format URL link yang benar
                            ->maxLength(255),
                    ]),
            ]);
    }
}