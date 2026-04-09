<?php

namespace App\Filament\Resources;

use App\Enums\ListingStatus;
use App\Enums\Region;
use App\Filament\Resources\PropertyListingResource\Pages;
use App\Models\PropertyListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PropertyListingResource extends Resource
{
    protected static ?string $model = PropertyListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?string $navigationLabel = 'Listings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Basic Information')
                            ->schema([
                                Forms\Components\TextInput::make('title')
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
                                Forms\Components\Textarea::make('description')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Pricing')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('£')
                                    ->helperText('Enter price in pounds (not pence)'),
                                Forms\Components\Select::make('price_qualifier')
                                    ->options([
                                        'asking' => 'Asking Price',
                                        'guide' => 'Guide Price',
                                        'offers_over' => 'Offers Over',
                                        'poa' => 'POA',
                                    ])
                                    ->required()
                                    ->default('asking'),
                            ])->columns(2),

                        Forms\Components\Section::make('Location')
                            ->schema([
                                Forms\Components\TextInput::make('address_line_1')
                                    ->required()
                                    ->maxLength(200),
                                Forms\Components\TextInput::make('address_line_2')
                                    ->maxLength(200),
                                Forms\Components\TextInput::make('town')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('county')
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('postcode')
                                    ->required()
                                    ->maxLength(10),
                                Forms\Components\Select::make('region')
                                    ->options(Region::options())
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Section::make('Property Details')
                            ->schema([
                                Forms\Components\Select::make('property_type')
                                    ->options([
                                        'freehold' => 'Freehold',
                                        'leasehold' => 'Leasehold',
                                        'both' => 'Both Available',
                                    ])
                                    ->required()
                                    ->default('freehold')
                                    ->live(),
                                Forms\Components\TextInput::make('lease_years_remaining')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('years')
                                    ->visible(fn (Forms\Get $get) => in_array($get('property_type'), ['leasehold', 'both'])),
                                Forms\Components\TextInput::make('rent_per_annum')
                                    ->numeric()
                                    ->prefix('£')
                                    ->suffix('/year')
                                    ->visible(fn (Forms\Get $get) => in_array($get('property_type'), ['leasehold', 'both'])),
                                Forms\Components\Toggle::make('has_accommodation')
                                    ->live(),
                                Forms\Components\Textarea::make('accommodation_details')
                                    ->rows(2)
                                    ->visible(fn (Forms\Get $get) => $get('has_accommodation')),
                            ])->columns(2),

                        Forms\Components\Section::make('Business Details')
                            ->schema([
                                Forms\Components\TextInput::make('monthly_items')
                                    ->numeric()
                                    ->suffix('items/month'),
                                Forms\Components\TextInput::make('annual_turnover')
                                    ->numeric()
                                    ->prefix('£')
                                    ->suffix('/year'),
                                Forms\Components\TextInput::make('annual_gross_profit')
                                    ->numeric()
                                    ->prefix('£')
                                    ->suffix('/year'),
                                Forms\Components\TextInput::make('staff_count')
                                    ->numeric()
                                    ->minValue(0),
                                Forms\Components\Toggle::make('nhs_contract')
                                    ->default(true),
                            ])->columns(2),

                        Forms\Components\Section::make('Agent Details')
                            ->schema([
                                Forms\Components\TextInput::make('agent_name')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('agent_company')
                                    ->maxLength(200),
                                Forms\Components\TextInput::make('agent_email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('agent_phone')
                                    ->tel()
                                    ->required(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options(ListingStatus::options())
                                    ->required()
                                    ->default('draft'),
                                Forms\Components\Toggle::make('featured')
                                    ->label('Featured Listing'),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date'),
                                Forms\Components\DateTimePicker::make('expires_at')
                                    ->label('Expiry Date'),
                            ]),

                        Forms\Components\Section::make('Payment')
                            ->schema([
                                Forms\Components\Select::make('payment_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'refunded' => 'Refunded',
                                    ])
                                    ->default('pending'),
                                Forms\Components\Select::make('listing_tier')
                                    ->options([
                                        'standard' => 'Standard',
                                        'featured' => 'Featured',
                                        'premium' => 'Premium',
                                    ])
                                    ->default('standard'),
                                Forms\Components\TextInput::make('payment_id')
                                    ->label('Stripe Payment ID')
                                    ->disabled(),
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
                                    ->content(fn (?PropertyListing $record) => $record?->views_count ?? 0),
                                Forms\Components\Placeholder::make('enquiries_count')
                                    ->label('Enquiries')
                                    ->content(fn (?PropertyListing $record) => $record?->enquiries_count ?? 0),
                                Forms\Components\Placeholder::make('saves_count')
                                    ->label('Saves')
                                    ->content(fn (?PropertyListing $record) => $record?->saves_count ?? 0),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40)
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('GBP', divideBy: 100)
                    ->sortable(),
                Tables\Columns\TextColumn::make('town')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->formatStateUsing(fn (Region $state) => $state->label())
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ListingStatus $state) => $state->label())
                    ->color(fn (ListingStatus $state) => $state->color()),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable(),
                Tables\Columns\TextColumn::make('enquiries_count')
                    ->label('Enquiries')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Owner')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ListingStatus::options()),
                Tables\Filters\SelectFilter::make('region')
                    ->options(Region::options()),
                Tables\Filters\TernaryFilter::make('featured'),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (PropertyListing $record) => $record->update([
                        'status' => ListingStatus::ACTIVE,
                        'published_at' => now(),
                    ]))
                    ->visible(fn (PropertyListing $record) => $record->status === ListingStatus::PENDING_REVIEW)
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
            'index' => Pages\ListPropertyListings::route('/'),
            'create' => Pages\CreatePropertyListing::route('/create'),
            'edit' => Pages\EditPropertyListing::route('/{record}/edit'),
        ];
    }
}
