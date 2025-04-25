<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceSkillResource\Pages;
use App\Filament\Resources\ExperienceSkillResource\RelationManagers;
use App\Models\Experience;
use App\Models\ExperienceSkill;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExperienceSkillResource extends Resource
{
    protected static ?string $model = ExperienceSkill::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('skill_id')
                    ->label('Choose Skill')
                    ->required()
                    ->options(Skill::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('experience_id')
                    ->label('Choose Experience')
                    ->required()
                    ->options(Experience::all()->pluck('name', 'id'))
                    ->searchable(),
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
                SelectColumn::make('skill_id')
                    ->label('Skill')
                    ->options(Skill::all()->pluck('name', 'id')),
                SelectColumn::make('experience_id')
                    ->label('Experience')
                    ->options(Experience::all()->pluck('name', 'id')),
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
            'index' => Pages\ListExperienceSkills::route('/'),
            'create' => Pages\CreateExperienceSkill::route('/create'),
            'edit' => Pages\EditExperienceSkill::route('/{record}/edit'),
        ];
    }
}
