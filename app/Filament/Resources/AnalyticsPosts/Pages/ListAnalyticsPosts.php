<?php

namespace App\Filament\Resources\AnalyticsPosts\Pages;

use App\Filament\Resources\AnalyticsPosts\AnalyticsPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnalyticsPosts extends ListRecords
{
    protected static string $resource = AnalyticsPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
