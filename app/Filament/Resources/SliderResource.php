<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\DateColumn;

use Illuminate\Support\Facades\App;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return false; // فعال / غیرفعال کردن 
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')
                ->label('عنوان')
                ->required(),

            TextInput::make('subtitle')
                ->label('زیرعنوان'),

                FileUpload::make('image')
                ->label('تصویر')
                ->image()
                ->directory('sliders')
                ->visibility('public')
                ->required(),

            TextInput::make('link')
                ->label('لینک')
                ->url()
                ->nullable(),

            DatePicker::make('publish_date')
                ->label('تاریخ انتشار')
                ->jalali()
                ->required(),

            Toggle::make('is_active')
                ->label('فعال؟')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('title')
                ->label('عنوان')
                ->searchable(),

            TextColumn::make('subtitle')
                ->label('زیرعنوان')
                ->limit(30)
                ->toggleable(),

                ImageColumn::make('image')
                    ->label('تصویر'),

                TextColumn::make('publish_date')
                ->label('تاریخ انتشار')
                ->date() // ✅ نمایش به‌صورت تاریخ
                ->when(App::isLocale('fa'), fn (TextColumn $column) => $column->jalaliDate()),
            IconColumn::make('is_active')
                ->label('فعال؟')
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
