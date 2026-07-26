<?php

namespace App\Filament\Resources\ClanMemberResource\Pages;

use App\Filament\Resources\ClanMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClanMembers extends ListRecords
{
    protected static string $resource = ClanMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
