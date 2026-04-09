<?php

namespace App\Filament\Resources;

use App\Enums\ArticleCategory;
use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Enums\UserRole;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                    ),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Brief summary for listings (max 500 chars)'),
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'orderedList',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                        'codeBlock',
                                        'redo',
                                        'undo',
                                    ]),
                            ]),

                        Forms\Components\Section::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('articles')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options(ArticleStatus::options())
                                    ->required()
                                    ->default('draft')
                                    ->disabled(fn () => !auth()->user()->canPublishContent())
                                    ->helperText(fn () => !auth()->user()->canPublishContent() 
                                        ? 'Only editors can publish articles' 
                                        : null),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->visible(fn (Forms\Get $get) => $get('status') === 'published'),
                            ]),

                        Forms\Components\Section::make('Classification')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->options(ArticleType::options())
                                    ->required()
                                    ->default('news'),
                                Forms\Components\Select::make('category')
                                    ->options(ArticleCategory::options())
                                    ->required(),
                                Forms\Components\TagsInput::make('tags')
                                    ->separator(',')
                                    ->suggestions([
                                        'NHS', 'Policy', 'Funding', 'IP', 'Pharmacy First',
                                        'Commissioning', 'Wholesaler', 'Technology', 'PMR',
                                    ]),
                            ]),

                        Forms\Components\Section::make('Access')
                            ->schema([
                                Forms\Components\Toggle::make('is_premium')
                                    ->label('Premium Content')
                                    ->helperText('Restrict to premium members'),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Article')
                                    ->helperText('Show on homepage'),
                            ]),

                        Forms\Components\Section::make('Author')
                            ->schema([
                                Forms\Components\Select::make('author_id')
                                    ->label('Author')
                                    ->relationship('author', 'first_name')
                                    ->getOptionLabelFromRecordUsing(fn (User $record) => $record->full_name)
                                    ->searchable()
                                    ->preload()
                                    ->default(auth()->id())
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular(false)
                    ->width(80)
                    ->height(45),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (ArticleType $state) => $state->label())
                    ->color(fn (ArticleType $state) => $state->color()),
                Tables\Columns\TextColumn::make('category')
                    ->formatStateUsing(fn (ArticleCategory $state) => $state->label())
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ArticleStatus $state) => $state->label())
                    ->color(fn (ArticleStatus $state) => $state->color()),
                Tables\Columns\IconColumn::make('is_premium')
                    ->label('Premium')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('author.full_name')
                    ->label('Author')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ArticleStatus::options()),
                Tables\Filters\SelectFilter::make('type')
                    ->options(ArticleType::options()),
                Tables\Filters\SelectFilter::make('category')
                    ->options(ArticleCategory::options()),
                Tables\Filters\TernaryFilter::make('is_premium'),
                Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-arrow-up-circle')
                    ->color('success')
                    ->action(fn (Article $record) => $record->publish())
                    ->visible(fn (Article $record) => 
                        $record->status !== ArticleStatus::PUBLISHED && auth()->user()->canPublishContent()
                    )
                    ->requiresConfirmation(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
