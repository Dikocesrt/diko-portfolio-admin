<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder("NodeJS")
                    ->required()
                    ->label("Skill Name")
                    ->maxLength(255),
                FileUpload::make('image')
                    ->maxSize(10240)
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('skills')
                    ->visibility('public')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->preserveFilenames()
                    ->maxFiles(1),
                TextInput::make('color')
                    ->placeholder("FFFFFF")
                    ->label("Color HEX")
                    ->maxLength(255),
                Select::make('category')
                    ->label('Skill Category')
                    ->required()
                    ->options([
                        'softskill' => 'Soft Skills',
                        'hardskill' => 'Hard Skills',
                        'softwareskill' => 'Software Skills',
                    ]),
                Select::make('is_star')
                    ->label('Starred Skill?')
                    ->required()
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ]),
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
                ImageColumn::make('image')
                    ->label('Image')
                    ->width(200)
                    ->height(200)
                    ->getStateUsing(fn ($record) => 'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload/' . $record->image),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Skill Name'),
                TextColumn::make('color')
                    ->label('Skill Color HEX'),
                SelectColumn::make('category')
                    ->label('Skill Category')
                    ->options([
                        'softskill' => 'Soft Skills',
                        'hardskill' => 'Hard Skills',
                        'softwareskill' => 'Software Skills',
                    ]),
                ToggleColumn::make('is_star')
                    ->default(false)
                    ->label('Starred Skill'),
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
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
