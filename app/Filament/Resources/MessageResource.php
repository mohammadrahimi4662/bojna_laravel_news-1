<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';
    protected static ?string $navigationLabel = 'حرف مردم';
    protected static ?string $modelLabel = 'پیام';
    protected static ?string $pluralModelLabel = 'پیام‌ها';

    protected static ?string $navigationGroup = 'حرف مردم';

    public static function getNavigationSort(): int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('content')
                    ->label('متن پیام')
                    ->rows(4)
                    ->required(),

                Textarea::make('response')
                    ->label('پاسخ مسئول')
                    ->rows(4)
                    ->nullable(),


                Toggle::make('status')
                    ->label('وضعیت نمایش')
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('content')
                ->label('متن پیام')
                ->limit(50)
                ->wrap(),

            TextColumn::make('response')
                ->label('پاسخ مسئول')
                ->limit(50)
                ->wrap(),

            // DateTimeColumn::make('published_at')
            //     ->label('تاریخ انتشار')
            //     ->format('Y/m/d H:i'),

            IconColumn::make('status')
                ->label('نمایش')
                ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
