<?php

namespace App\Filament\Resources;

use App\Enums\JobTitle;
use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users & Access';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Select::make('job_title')
                            ->options(JobTitle::options())
                            ->required(),
                        Forms\Components\TextInput::make('gphc_number')
                            ->maxLength(7)
                            ->regex('/^\d{7}$/')
                            ->helperText('7-digit GPhC registration number'),
                    ])->columns(2),

                Forms\Components\Section::make('Pharmacy Context')
                    ->schema([
                        Forms\Components\Toggle::make('currently_own_pharmacy')
                            ->live(),
                        Forms\Components\TextInput::make('number_of_pharmacies')
                            ->numeric()
                            ->minValue(1)
                            ->visible(fn (Forms\Get $get) => $get('currently_own_pharmacy')),
                        Forms\Components\TextInput::make('current_workplace')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('looking_to_buy')
                            ->live(),
                        Forms\Components\TextInput::make('buy_location_preference')
                            ->maxLength(255)
                            ->visible(fn (Forms\Get $get) => $get('looking_to_buy')),
                    ])->columns(2),

                Forms\Components\Section::make('Role & Permissions')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->options(UserRole::options())
                            ->required(),
                        Forms\Components\Toggle::make('newsletter_subscribed')
                            ->default(true),
                        Forms\Components\DateTimePicker::make('email_verified_at'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn (UserRole $state) => $state->label())
                    ->color(fn (UserRole $state) => match ($state) {
                        UserRole::ADMIN => 'danger',
                        UserRole::EDITOR => 'warning',
                        UserRole::CONTENT_EDITOR => 'info',
                        UserRole::ESTATE_AGENT => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('job_title')
                    ->formatStateUsing(fn (JobTitle $state) => $state->label())
                    ->toggleable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(UserRole::options()),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('looking_to_buy')
                    ->label('Looking to Buy'),
                Tables\Filters\TernaryFilter::make('currently_own_pharmacy')
                    ->label('Pharmacy Owners'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('verify')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (User $record) => $record->update(['email_verified_at' => now()]))
                    ->visible(fn (User $record) => !$record->email_verified_at)
                    ->requiresConfirmation(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
