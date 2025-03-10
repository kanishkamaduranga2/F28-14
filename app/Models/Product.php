<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'sku',
        'name',
        'logo',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
          ///  ->useDisk('tenant')        // Use the tenant disk for storage
            ->singleFile();                     // If you want to allow only one file per collection
    }
}
