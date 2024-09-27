<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('created_at', 'desc'); // Query default untuk sorting
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                ->label('Order Code')
                ->disabled()
                ->string(),
                
                TextInput::make('phone_number')
                ->required()
                ->minLength(10)
                ->maxLength(15)
                ->string(),
                
                TextInput::make('fullname')
                ->required()
                ->minLength(3)
                ->maxLength(255)
                ->string(),
                
                Textarea::make('address')
                ->required()
                ->minLength(8)
                ->maxLength(500)
                ->string(),

                // Textarea::make('address')
                // ->required()
                // ->minLength(8)
                // ->maxLength(1000)
                // ->string(),

                TextInput::make('subtotal')
                ->numeric()
                ->prefix('Rp ')
                ->disabled(),

                TextInput::make('tax')
                ->numeric()
                ->prefix('Rp ')
                ->disabled(),

                TextInput::make('fee')
                ->numeric()
                ->prefix('Rp ')
                ->disabled(),

                TextInput::make('total_amount')
                ->numeric()
                ->prefix('Rp ')
                ->disabled()
                ->disabled(),

                TextInput::make('duration')
                ->numeric()
                ->prefix('Day(s)')
                ->minValue(1)
                ->maxValue(30)
                ->required()
                ->disabled(),

                Select::make('store_id')
                ->relationship('store', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->disabled(),

                Select::make('product_id')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->disabled(),

                DatePicker::make('started_at')
                ->required()
                ->disabled(),

                DatePicker::make('ended_at')
                ->required()
                ->disabled(),

                Select::make('delivery_type')
                    ->options([
                        'PICKUP' => 'Pick Up',
                        'HOME_DELIVERY' => 'Home Delivery',
                    ])
                    ->required(),

                Select::make('status')
                    ->options([
                        'PENDING' => 'Pending',
                        'SUCCESS' => 'Success',
                        'CANCELED' => 'Canceled',
                    ])
                    ->required(),
                
                // ImageColumn::make('proof')
                        

                FileUpload::make('proof')
                ->required()
                ->image()
                ->openable()
                ->directory('uploads/transactions')
                ->disabled()

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->label('Order Code'),

                TextColumn::make('fullname')->searchable(),

                TextColumn::make('product.name'),

                TextColumn::make('duration')
                ->label('Duration (days)'),

                IconColumn::make('status')
                ->icon(fn (string $state): string => match ($state) {
                    'heroicon-o-question-mark-circle',
                    'PENDING' => 'heroicon-o-clock',
                    'CANCELED' => 'heroicon-o-x-circle',
                    'SUCCESS' => 'heroicon-o-check-circle',
                })
                ->colors([
                    'secondary',
                    'warning' => 'PENDING',
                    'danger' => 'CANCELED',
                    'success' => 'SUCCESS',
                ]),
            ])
            ->filters([
                SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'PENDING' => 'Pending',
                    'SUCCESS' => 'Success',
                    'CANCELED' => 'Canceled',
                ]),

                Filter::make('started_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('started_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('started_at', '<=', $date),
                        );
                }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
