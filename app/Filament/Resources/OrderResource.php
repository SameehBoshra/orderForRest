<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Orders';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Details')
                    ->schema([
                        Section::make('Customer Details')
                            ->description('Fill in the customer details')
                            ->schema([
                                Forms\Components\TextInput::make('customer_name')
                                ->required()
                                ->label('Customer Name'),
                                Forms\Components\TextInput::make('customer_phone')
                                ->label('Customer Phone')
                                ->required()
                                ->tel()
                                ->rule('regex:/^01[0-2,5]{1}[0-9]{8}$/')
                                ->maxLength(11)
                                ->minLength(11)
                                ->unique(Order::class, 'customer_phone', ignoreRecord: true),

                            Forms\Components\TextInput::make('customer_address')
                                ->required()
                                ->label('Customer Address'),
                            ])->columns(3),

                        Section::make('Order Details')
                            ->description('Fill in the order details')
                            ->schema([
                                Forms\Components\Select::make('name_product')
                                ->label('Product Name')
                                ->relationship('product','name')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set ,callable $get) {
                                    $product = \App\Models\Product::find($state);
                                    if ($product) {
                                        $set('price', $product->price);
                                        $set('total_price', $product->price * $get('quantity'));
                                    }
                                }),
                                Forms\Components\TextInput::make('quantity')
                                ->label('Quantity')
                                ->default(1)
                                ->required()
                                ->numeric()
                                ->integer()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('total_price', $get('price') * $state); // إعادة حساب الإجمالي
                                }),

                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->numeric()
                                ->required(),

                            Forms\Components\TextInput::make('total_price')
                                ->label('Total Price')
                                ->numeric()
                                ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'Preparation' => 'Preparation',
                                'On the way' => 'On the way',
                                'Delivered' => 'Delivered',
                                'Cancelled' => 'Cancelled',
                            ])
                            ->default('Preparation')
                            ->label('Status'),
                            ])->columns(2),



                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Customer Phone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_address')
                    ->label('Customer Address')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->url(fn ($record) => route('orders.print', $record->id))
                ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
