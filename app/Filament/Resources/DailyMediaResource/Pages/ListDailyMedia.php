<?php

namespace App\Filament\Resources\DailyMediaResource\Pages;

use App\Filament\Resources\DailyMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyMedia extends ListRecords
{
    protected static string $resource = DailyMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
