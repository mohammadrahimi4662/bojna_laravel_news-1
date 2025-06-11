<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'دسته‌بندی‌ها'; // متن در سایدبار
    protected static ?string $pluralLabel = 'دسته‌بندی‌ها';     // عنوان لیست
    protected static ?string $modelLabel = 'دسته‌بندی';         // عنوان مفرد
    protected static ?string $navigationGroup = 'مدیریت محتوا';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                ->label('عنوان')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('slug')
                ->label('اسلاگ')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('توضیحات')
                ->rows(3)
                ->nullable(),

            Forms\Components\Toggle::make('status')
                ->label('فعال / غیرفعال')
                ->default(true),

            Forms\Components\Section::make('سئو')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(255)
                        ->nullable(),

                    Forms\Components\TextInput::make('meta_keywords')
                        ->label('Meta Keywords')
                        ->maxLength(255)
                        ->nullable(),

                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(2)
                        ->nullable(),
                ])->collapsible(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                            Tables\Columns\TextColumn::make('title')
                ->label('عنوان')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('وضعیت')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
