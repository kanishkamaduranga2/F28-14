<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Tables\Columns\TenantAwareImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Products'; // Label for the sidebar

    protected static ?string $navigationGroup = 'Shop'; // Group in the sidebar

    // Restrict this resource to the 'admin' panel
//    public static function getNavigationBadge(): ?string
//    {
//        return static::getModel()->count();
//    }

    public static function shouldRegisterNavigation(): bool
    {
        // Only register this resource in the 'admin' panel
        return filament()->getCurrentPanel()?->getId() === 'admin';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sku')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('SKU'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Product Name'),
                SpatieMediaLibraryFileUpload::make('logo')
                    ->label('Product Logo')
                    ->collection('logo') // Match the media collection name
                    ->disk('tenant') // Use the tenant disk
                    ->image()
                    ->nullable(),
                Forms\Components\Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),
                TenantAwareImageColumn::make('logo')
                    ->label('Logo')
                    ->collection('logo')
                  //  ->disk('tenant')
                    ->circular(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Active Products')
                    ->query(fn ($query) => $query->where('status', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    protected function afterSave(): void
    {
        $product = $this->getRecord();
        $mediaUrl = $product->getFirstMediaUrl('logo');
        $product->update(['logo' => $mediaUrl]);
    }
}
