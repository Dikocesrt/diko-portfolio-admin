<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectSkillResource\Pages;
use App\Filament\Resources\ProjectSkillResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectSkill;
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

class ProjectSkillResource extends Resource
{
    protected static ?string $model = ProjectSkill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('skill_id')
                    ->label('Choose Skill')
                    ->required()
                    ->options(Skill::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('project_id')
                    ->label('Choose Project')
                    ->required()
                    ->options(Project::all()->pluck('name', 'id'))
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
                SelectColumn::make('project_id')
                    ->label('Project')
                    ->options(Project::all()->pluck('name', 'id')),
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
            'index' => Pages\ListProjectSkills::route('/'),
            'create' => Pages\CreateProjectSkill::route('/create'),
            'edit' => Pages\EditProjectSkill::route('/{record}/edit'),
        ];
    }
}
