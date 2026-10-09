<?php

namespace App\Filament\Resources\AnalyticsPosts\Pages;

use App\Filament\Resources\AnalyticsPosts\AnalyticsPostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnalyticsPost extends EditRecord
{
    protected static string $resource = AnalyticsPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
