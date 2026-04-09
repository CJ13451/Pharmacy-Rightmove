<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Training';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Course Details')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state) . '-' . Str::random(6)) : null
                                    ),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Forms\Components\TagsInput::make('learning_outcomes')
                                    ->placeholder('Add a learning outcome')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->image()
                                    ->directory('courses')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('450'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->required()
                                    ->default('draft'),
                            ]),

                        Forms\Components\Section::make('Pricing')
                            ->schema([
                                Forms\Components\Toggle::make('is_free')
                                    ->label('Free Course')
                                    ->live()
                                    ->default(false),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('£')
                                    ->helperText('Price in pounds')
                                    ->visible(fn (Forms\Get $get) => !$get('is_free')),
                                Forms\Components\Toggle::make('is_premium')
                                    ->label('Premium Only')
                                    ->helperText('Restrict to premium members'),
                            ]),

                        Forms\Components\Section::make('Accreditation')
                            ->schema([
                                Forms\Components\Toggle::make('cpd_accredited')
                                    ->label('CPD Accredited')
                                    ->live(),
                                Forms\Components\TextInput::make('cpd_points')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn (Forms\Get $get) => $get('cpd_accredited')),
                                Forms\Components\TextInput::make('accreditation_body')
                                    ->maxLength(255)
                                    ->visible(fn (Forms\Get $get) => $get('cpd_accredited')),
                            ]),

                        Forms\Components\Section::make('Stats')
                            ->schema([
                                Forms\Components\Placeholder::make('enrolments_count')
                                    ->label('Enrolments')
                                    ->content(fn (?Course $record) => $record?->enrolments_count ?? 0),
                                Forms\Components\Placeholder::make('completions_count')
                                    ->label('Completions')
                                    ->content(fn (?Course $record) => $record?->completions_count ?? 0),
                                Forms\Components\Placeholder::make('completion_rate')
                                    ->label('Completion Rate')
                                    ->content(fn (?Course $record) => ($record?->completion_rate ?? 0) . '%'),
                            ])->columns(3),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->width(80)
                    ->height(45),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray',
                        'published' => 'green',
                        'archived' => 'red',
                    }),
                Tables\Columns\IconColumn::make('is_free')
                    ->label('Free')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money('GBP', divideBy: 100)
                    ->placeholder('Free'),
                Tables\Columns\IconColumn::make('cpd_accredited')
                    ->label('CPD')
                    ->boolean(),
                Tables\Columns\TextColumn::make('enrolments_count')
                    ->label('Enrolments')
                    ->sortable(),
                Tables\Columns\TextColumn::make('completions_count')
                    ->label('Completed')
                    ->sortable(),
                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Modules')
                    ->counts('modules'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\TernaryFilter::make('is_free'),
                Tables\Filters\TernaryFilter::make('cpd_accredited'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ModulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
