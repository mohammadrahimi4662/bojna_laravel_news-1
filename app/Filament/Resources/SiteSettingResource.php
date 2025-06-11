<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\{
    FileUpload,
    Toggle,
    Repeater,
    TextInput,
    Textarea,
    Select
};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Get;


class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Site Settings';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('logo_type')
                ->label('نوع لوگو')
                ->options([
                    'text' => 'متن',
                    'image' => 'تصویر',
                ])
                ->default('text')
                ->required()
                ->reactive(),

            FileUpload::make('logo_image')
                ->label('لوگو (تصویر)')
                ->image()
                ->directory('logos')
                ->visible(fn (Get $get) => $get('logo_type') === 'image'),

            TextInput::make('logo_text')
                ->label('لوگو (متنی)')
                ->visible(fn (Get $get) => $get('logo_type') === 'text'),

                // Toggle::make('show_date_info')
                //     ->label('نمایش تاریخ شمسی، قمری، میلادی در هدر'),

                // Repeater::make('header_menu')
                //     ->label('منوی هدر')
                //     ->schema([
                //         TextInput::make('title')->label('عنوان')->required(),
                //         TextInput::make('url')->label('لینک')->required(),
                //     ]),

                // FileUpload::make('footer_banner')
                //     ->label('بنر فوتر')
                //     ->image()
                //     ->directory('banners'),

                Textarea::make('footer_about')
                    ->label('متن درباره ما')
                    ->columnSpan('full'),

                // Repeater::make('footer_quick_links')
                //     ->label('لینک‌های سریع')
                //     ->schema([
                //         TextInput::make('title')->label('عنوان'),
                //         TextInput::make('url')->label('لینک'),
                //     ]),

                Repeater::make('footer_social_links')
                    ->label('لینک شبکه‌های اجتماعی')
                    ->columnSpan('full')
                    ->schema([
                        TextInput::make('platform')->label('نام پلتفرم'),
                        TextInput::make('url')->label('لینک'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('logo_type')
                ->label('نوع لوگو')
                ->badge()
                ->formatStateUsing(fn ($state) => $state === 'text' ? 'متنی' : 'تصویری'),

            TextColumn::make('logo_type')
                ->label('لوگو')
                ->html() // اجازه استفاده از HTML
                ->formatStateUsing(function ($state, $record) {
                    // dd($record->logo_type);
                    if ($record->logo_type === 'text') {
                        return e($record->logo_text); // متن ساده
                    } elseif ($record->logo_type === 'image' && $record->logo_image) {
                        $url = Storage::disk('public')->url($record->logo_image);
                        return "<img src='{$url}' style='height:40px; border-radius:4px;' />";
                    }
                    return '-';
                }),
                // TextColumn::make('id')->label('شناسه')->sortable(),
                // TextColumn::make('logo_type')
                //     ->label('نوع لوگو')
                //     ->badge()
                //     ->formatStateUsing(fn ($state) => $state === 'text' ? 'متنی' : 'تصویری'),

                //     // ImageColumn::make('image')
                //     //     ->label('لوگو')
                //     //     ->square()
                //     //     ->disk('public') // اگر از disk public استفاده می‌کنی
                //     //     // ->url(fn ($record) => asset('storage/' . $record->logo_image)), // مسیر دستی
                //     //     ->url(fn ($record) => Storage::disk('storage')->url($record->logo)),
                // ImageColumn::make('logo_image')
                //     ->label('لوگو')
                //     ->url(fn ($record) => $record->logo_image),

                // IconColumn::make('show_date_info')
                //     ->label('نمایش تاریخ')
                //     ->boolean(),

                // TextColumn::make('updated_at')
                //     ->label('آخرین ویرایش')
                //     ->dateTime('Y/m/d H:i'),
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
