<?php

namespace App\Filament\Resources\ClanMemberResource\Pages;

use App\Filament\Resources\ClanMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClanMember extends EditRecord
{
    protected static string $resource = ClanMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
