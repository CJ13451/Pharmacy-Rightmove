<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull(),

                Forms\Components\Select::make('content_type')
                    ->options([
                        'text' => 'Text Content',
                        'video' => 'Video',
                        'scorm' => 'SCORM Package',
                        'download' => 'Download',
                        'quiz' => 'Quiz',
                    ])
                    ->required()
                    ->live()
                    ->default('text'),

                Forms\Components\RichEditor::make('content_body')
                    ->label('Content')
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'text')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('video_url')
                    ->label('Video URL')
                    ->url()
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'video'),

                Forms\Components\Select::make('video_provider')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                        'wistia' => 'Wistia',
                        'uploaded' => 'Uploaded File',
                    ])
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'video'),

                Forms\Components\FileUpload::make('scorm_package_url')
                    ->label('SCORM Package (.zip)')
                    ->acceptedFileTypes(['application/zip'])
                    ->directory('scorm')
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'scorm'),

                Forms\Components\Select::make('scorm_version')
                    ->options([
                        '1.2' => 'SCORM 1.2',
                        '2004' => 'SCORM 2004',
                    ])
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'scorm'),

                Forms\Components\FileUpload::make('download_url')
                    ->label('Download File')
                    ->directory('course-downloads')
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'download'),

                Forms\Components\TextInput::make('download_name')
                    ->label('Display Name for Download')
                    ->visible(fn (Forms\Get $get) => $get('content_type') === 'download'),

                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Duration (minutes)')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),

                Forms\Components\TextInput::make('position')
                    ->label('Order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),

                Forms\Components\Toggle::make('requires_completion')
                    ->label('Requires Completion')
                    ->default(true),

                Forms\Components\TextInput::make('pass_percentage')
                    ->label('Pass Percentage')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%')
                    ->visible(fn (Forms\Get $get) => in_array($get('content_type'), ['scorm', 'quiz'])),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('position')
            ->defaultSort('position')
            ->columns([
                Tables\Columns\TextColumn::make('position')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('content_type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'text' => 'gray',
                        'video' => 'info',
                        'scorm' => 'warning',
                        'download' => 'success',
                        'quiz' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->suffix(' min'),
                Tables\Columns\IconColumn::make('requires_completion')
                    ->label('Required')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
