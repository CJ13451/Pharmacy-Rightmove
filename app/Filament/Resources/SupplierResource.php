<?php

namespace App\Filament\Resources;

use App\Enums\SupplierCategory;
use App\Enums\SupplierTier;
use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Directory';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Basic Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(200)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state) . '-' . Str::random(6)) : null
                                    ),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Select::make('category')
                                    ->options(SupplierCategory::options())
                                    ->required(),
                                Forms\Components\Textarea::make('short_description')
                                    ->required()
                                    ->rows(2)
                                    ->maxLength(200)
                                    ->helperText('Max 200 characters'),
                                Forms\Components\Textarea::make('long_description')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Contact Details')
                            ->schema([
                                Forms\Components\TextInput::make('contact_name')
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('contact_email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('contact_phone')
                                    ->tel()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('website')
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('address')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->image()
                                    ->directory('suppliers/logos')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('400')
                                    ->imageResizeTargetHeight('400'),
                                Forms\Components\FileUpload::make('photos')
                                    ->multiple()
                                    ->image()
                                    ->directory('suppliers/photos')
                                    ->maxFiles(10)
                                    ->reorderable(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'active' => 'Active',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->required()
                                    ->default('pending'),
                                Forms\Components\Select::make('tier')
                                    ->options(SupplierTier::options())
                                    ->required()
                                    ->default('free'),
                            ]),

                        Forms\Components\Section::make('Subscription')
                            ->schema([
                                Forms\Components\Select::make('subscription_status')
                                    ->options([
                                        'none' => 'None',
                                        'active' => 'Active',
                                        'past_due' => 'Past Due',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('none'),
                                Forms\Components\TextInput::make('stripe_subscription_id')
                                    ->disabled(),
                                Forms\Components\DateTimePicker::make('subscription_expires_at'),
                            ]),

                        Forms\Components\Section::make('Owner')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'email')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Analytics')
                            ->schema([
                                Forms\Components\Placeholder::make('views_count')
                                    ->label('Views')
                                    ->content(fn (?Supplier $record) => $record?->views_count ?? 0),
                                Forms\Components\Placeholder::make('clicks_count')
                                    ->label('Website Clicks')
                                    ->content(fn (?Supplier $record) => $record?->clicks_count ?? 0),
                            ])->columns(2),

                        Forms\Components\Section::make('Social Links')
                            ->schema([
                                Forms\Components\KeyValue::make('social_links')
                                    ->keyLabel('Platform')
                                    ->valueLabel('URL')
                                    ->addActionLabel('Add social link'),
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
                Tables\Columns\ImageColumn::make('logo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?background=00875a&color=fff&name=S'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->formatStateUsing(fn (SupplierCategory $state) => $state->label())
                    ->badge(),
                Tables\Columns\TextColumn::make('tier')
                    ->formatStateUsing(fn (SupplierTier $state) => $state->label())
                    ->badge()
                    ->color(fn (SupplierTier $state) => $state->color()),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'suspended' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable(),
                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Clicks')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Owner')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                    ]),
                Tables\Filters\SelectFilter::make('tier')
                    ->options(SupplierTier::options()),
                Tables\Filters\SelectFilter::make('category')
                    ->options(SupplierCategory::options()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Supplier $record) => $record->update(['status' => 'active']))
                    ->visible(fn (Supplier $record) => $record->status === 'pending')
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
