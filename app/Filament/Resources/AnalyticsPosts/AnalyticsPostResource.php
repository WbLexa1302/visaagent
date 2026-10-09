<?php

namespace App\Filament\Resources\AnalyticsPosts;

use App\Filament\Resources\AnalyticsPosts\Pages\CreateAnalyticsPost;
use App\Filament\Resources\AnalyticsPosts\Pages\EditAnalyticsPost;
use App\Filament\Resources\AnalyticsPosts\Pages\ListAnalyticsPosts;
use App\Filament\Resources\AnalyticsPosts\Schemas\AnalyticsPostForm;
use App\Filament\Resources\AnalyticsPosts\Tables\AnalyticsPostsTable;
use App\Models\AnalyticsPost;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnalyticsPostResource extends Resource
{
    protected static ?string $model = AnalyticsPost::class;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 8;

    protected static ?string $recordTitleAttribute = 'Analytics Post';

    public static function form(Schema $schema): Schema
    {
        return AnalyticsPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnalyticsPostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnalyticsPosts::route('/'),
            'create' => CreateAnalyticsPost::route('/create'),
            'edit' => EditAnalyticsPost::route('/{record}/edit'),
        ];
    }
}
