<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Kita bungkus menggunakan Grid agar rapi menjadi 2 kolom
                        Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('product_id')
                            ->label('Produk Visa')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('unique_code')
                            ->label('Kode Unik')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('booking_code')
                            ->label('Kode Booking')
                            ->required(),

                        TextInput::make('visa_type')
                            ->label('Tipe Visa (dari Sheet)')
                            ->placeholder('Contoh: C1, VOA, dll'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'completed' => 'Selesai',
                            ])
                            ->required()
                            ->default('pending'),

                        DatePicker::make('submission_date')
                            ->label('Tanggal Submit'),

                        DatePicker::make('completion_date')
                            ->label('Tanggal Selesai / Estimasi'),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(), // Agar text area memanjang penuh bawah
            ]);
    }
}
