<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Models\Experience;
use App\Models\ExperienceCategory;
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

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder("Alterra Academy")
                    ->required()
                    ->label("Experience Name")
                    ->maxLength(255),
                FileUpload::make('image')
                    ->maxSize(10240)
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('places')
                    ->visibility('public')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->preserveFilenames()
                    ->maxFiles(1),
                TextInput::make('company')
                    ->placeholder("Bangkit Academy")
                    ->required()
                    ->label("Agency")
                    ->maxLength(255),
                TextInput::make('location')
                    ->placeholder("Yogyakarta")
                    ->required()
                    ->label("Location")
                    ->maxLength(255),
                Select::make('location_type')
                    ->required()
                    ->label('Location Type')
                    ->options([
                        'onsite' => 'Onsite',
                        'hybrid' => 'Hybrid',
                        'remote' => 'Remote',
                    ]),
                Select::make('month_start')
                    ->required()
                    ->label('Month Start Experience')
                    ->options([
                        'Januari' => 'January',
                        'Februari' => 'February',
                        'Maret' => 'March',
                        'April' => 'April',
                        'Mei' => 'May',
                        'Juni' => 'June',
                        'Juli' => 'July',
                        'Agustus' => 'August',
                        'September' => 'September',
                        'Oktober' => 'October',
                        'November' => 'November',
                        'Desember' => 'December',
                    ]),
                TextInput::make('year_start')
                    ->placeholder("2022")
                    ->required()
                    ->label("Year Start Experience")
                    ->maxLength(255),
                Select::make('month_end')
                    ->required()
                    ->label('Month Finish Experience')
                    ->options([
                        'Januari' => 'January',
                        'Februari' => 'February',
                        'Maret' => 'March',
                        'April' => 'April',
                        'Mei' => 'May',
                        'Juni' => 'June',
                        'Juli' => 'July',
                        'Agustus' => 'August',
                        'September' => 'September',
                        'Oktober' => 'October',
                        'November' => 'November',
                        'Desember' => 'December',
                    ]),
                TextInput::make('year_end')
                    ->placeholder("2024")
                    ->required()
                    ->label("Year Start Experience")
                    ->maxLength(255),
                TextInput::make('position')
                    ->placeholder("Fullstack Engineer")
                    ->required()
                    ->label("Position")
                    ->maxLength(255),
                Select::make('employment_type')
                    ->required()
                    ->label('Employment Type')
                    ->options([
                        'fulltime' => 'Full Time',
                        'parttime' => 'Part Time',
                        'contract' => 'Contract',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                        'seasonal' => 'Seasonal',
                    ]),
                Select::make('is_star')
                    ->label('Starred Skill?')
                    ->required()
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ]),
                Select::make('experience_category_id')
                    ->label('Experience Category')
                    ->required()
                    ->options(ExperienceCategory::all()->pluck('name', 'id')),
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
                TextColumn::make('company')
                    ->searchable()
                    ->label('Agency'),
                TextColumn::make('description')
                    ->wrap()
                    ->limit(50)
                    ->label('Description'),
                TextColumn::make('location')
                    ->searchable()
                    ->label('Location'),
                SelectColumn::make('location_type')
                    ->label('Location Type')
                    ->options([
                        'onsite' => 'Onsite',
                        'hybrid' => 'Hybrid',
                        'remote' => 'Remote',
                    ]),
                SelectColumn::make('month_start')
                    ->label('Month Start Experience')
                    ->options([
                        'Januari' => 'January',
                        'Februari' => 'February',
                        'Maret' => 'March',
                        'April' => 'April',
                        'Mei' => 'May',
                        'Juni' => 'June',
                        'Juli' => 'July',
                        'Agustus' => 'August',
                        'September' => 'September',
                        'Oktober' => 'October',
                        'November' => 'November',
                        'Desember' => 'December',
                    ]),
                TextColumn::make('year_start')
                    ->label('Year Start Experience'),
                SelectColumn::make('month_end')
                    ->label('Month Finish Experience')
                    ->options([
                        'Januari' => 'January',
                        'Februari' => 'February',
                        'Maret' => 'March',
                        'April' => 'April',
                        'Mei' => 'May',
                        'Juni' => 'June',
                        'Juli' => 'July',
                        'Agustus' => 'August',
                        'September' => 'September',
                        'Oktober' => 'October',
                        'November' => 'November',
                        'Desember' => 'December',
                    ]),
                TextColumn::make('year_end')
                    ->label('Year Finish Experience'),
                TextColumn::make('position')
                    ->searchable()
                    ->label('Position'),
                SelectColumn::make('employment_type')
                    ->label('Employment Type')
                    ->options([
                        'fulltime' => 'Full Time',
                        'parttime' => 'Part Time',
                        'contract' => 'Contract',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                        'seasonal' => 'Seasonal',
                    ]),
                ToggleColumn::make('is_star')
                    ->label('Starred Skill'),
                SelectColumn::make('experience_category_id')
                    ->label('Experience Category')
                    ->options(ExperienceCategory::all()->pluck('name', 'id')),
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
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
