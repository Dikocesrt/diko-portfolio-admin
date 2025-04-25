<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Experience;
use App\Models\Project;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
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

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder("Mental Guardians")
                    ->required()
                    ->label("Name")
                    ->maxLength(255),
                FileUpload::make('image')
                    ->maxSize(10240)
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
                    ->visibility('public')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->preserveFilenames()
                    ->maxFiles(1),
                TextInput::make('date')
                    ->placeholder("Desember 2025")
                    ->required()
                    ->label("Project Date")
                    ->maxLength(255),
                Select::make('type')
                    ->required()
                    ->label('Project Type')
                    ->options([
                        'website' => 'Website',
                        'mobile' => 'Mobile',
                        'api' => 'API',
                    ]),
                Select::make('is_star')
                    ->label('Starred Project?')
                    ->required()
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ]),
                Select::make('experience_id')
                    ->label('Experience')
                    ->required()
                    ->options(Experience::all()->pluck('name', 'id')),
                Select::make('project_category_id')
                    ->label('Project Category')
                    ->required()
                    ->options(ProjectCategory::all()->pluck('name', 'id')),
                MarkdownEditor::make('description')
                    ->columnSpan('full')
                    ->required()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'heading',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'table',
                        'undo',
                    ])
                    ->label("Description"),
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
                    ->width(350)
                    ->height(200)
                    ->getStateUsing(fn ($record) => 'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload/' . $record->image),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('date')
                    ->searchable()
                    ->label('Project Date'),
                SelectColumn::make('type')
                    ->label('Type')
                    ->options([
                        'website' => 'Website',
                        'mobile' => 'Mobile',
                        'api' => 'API',
                    ]),
                ToggleColumn::make('is_star')
                    ->label('Starred Project?'),
                TextColumn::make('description')
                    ->wrap()
                    ->limit(50)
                    ->label('Description'),
                SelectColumn::make('experience_id')
                    ->label('Experience')
                    ->options(Experience::all()->pluck('name', 'id')),
                SelectColumn::make('project_category_id')
                    ->label('Project Category')
                    ->options(ProjectCategory::all()->pluck('name', 'id')),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
