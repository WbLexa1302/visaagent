<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput; // Pastikan import ini ada

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('passport_number')
                    ->label('No. Passport')
                    ->required()
                    ->maxLength(50),

                TextInput::make('phone')
                    ->label('Telepon')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('nationality')
                    ->label('Kewarganegaraan')
                    ->maxLength(100),
            ]);
    }
}
