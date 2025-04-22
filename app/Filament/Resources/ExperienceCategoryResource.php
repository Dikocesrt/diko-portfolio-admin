<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceCategoryResource\Pages;
use App\Filament\Resources\ExperienceCategoryResource\RelationManagers;
use App\Models\ExperienceCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExperienceCategoryResource extends Resource
{
    protected static ?string $model = ExperienceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder("MSIB")
                    ->required()
                    ->label("Experience Category Name")
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->sortable()
                    ->label('Date Input')
                    ->dateTime(),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Experience Category Name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListExperienceCategories::route('/'),
            'create' => Pages\CreateExperienceCategory::route('/create'),
            'edit' => Pages\EditExperienceCategory::route('/{record}/edit'),
        ];
    }
}
