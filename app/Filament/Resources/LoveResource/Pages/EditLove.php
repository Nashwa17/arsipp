<?php

namespace App\Filament\Resources\LoveResource\Pages;

use App\Filament\Resources\LoveResource;
use App\Models\love;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditLove extends EditRecord
{
    protected static string $resource = LoveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(
                function(love $record) {
                    if($record->thumbnail) {
                        Storage::disk('public')->delete($record->thumbnail);
                    }
                }
            ),
        ];
    }
}
