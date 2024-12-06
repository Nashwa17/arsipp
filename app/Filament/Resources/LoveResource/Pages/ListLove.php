<?php

namespace App\Filament\Resources\LoveResource\Pages;

use App\Filament\Resources\LoveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLove extends ListRecords
{
    protected static string $resource = LoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
