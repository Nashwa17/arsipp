<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoveResource\Pages;
use App\Filament\Resources\LoveResource\RelationManagers;
use App\Models\Love;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class LoveResource extends Resource
{
    protected static ?string $model = Love::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Card::make()-> schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('thumbnail')
                    ->required()->image()->disk('public'),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->maxLength(255),
            ]),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make()->after(function (Collection $record) {
                            foreach($record as $key => $value){
                                if($value->thumbnail){
                                    Storage::disk('public')->delete($value->exif_thumbnail);
                                }
                            }
                        }),
                    ]),
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
            'index' => Pages\ListLove::route('/'),
            'create' => Pages\CreateLove::route('/create'),
            'edit' => Pages\EditLove::route('/{record}/edit'),
        ];
    }
}
