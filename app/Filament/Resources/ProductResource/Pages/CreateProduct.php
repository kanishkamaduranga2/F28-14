<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterSave(): void
    {
        \log::info('create after save : ', [ 'kkkk']);
        $product = $this->getRecord();
        $mediaUrl = $product->getFirstMediaUrl('logo');
        $product->update(['logo' => $mediaUrl]);
    }

}
