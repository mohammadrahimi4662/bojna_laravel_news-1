<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyMediaResource\Pages;
use App\Filament\Resources\DailyMediaResource\RelationManagers;
use App\Models\DailyMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload, Select, Toggle, DateTimePicker};
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Columns\{TextColumn, IconColumn, ImageColumn, ToggleColumn};
use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;

class DailyMediaResource extends Resource
{
    protected static ?string $model = DailyMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'مدیریت محتوای تصاویر / ویدیو';
    protected static ?string $modelLabel = 'ویدیو / تصویر شاخص روز';         // عنوان مفرد
    protected static ?string $pluralLabel = 'ویدیو / تصویر شاخص روز';          // جمع
    protected static ?string $navigationLabel = 'ویدیو / تصویر شاخص روز';      // عنوان در سایدبار

    public static function form(Form $form): Form
{
    return $form

    ->schema([
        TextInput::make('title')
            ->required()
            ->label('عنوان'),

        Textarea::make('lead')
            ->label('لید')
            ->rows(3),

        Select::make('media_type')
            ->options([
                'image' => 'تصویر',
                'video' => 'ویدیو (فقط لینک خارجی)',
            ])
            ->required()
            ->live()
            ->disabled(fn ($livewire) => $livewire instanceof EditRecord),

        FileUpload::make('image_upload')
            ->label('آپلود تصویر')
            ->disk('public')
            ->directory('daily-media')
            ->preserveFilenames()
            ->acceptedFileTypes(['image/*'])
            ->visible(fn (Forms\Get $get) => $get('media_type') === 'image')
            ->required(fn (Forms\Get $get) => $get('media_type') === 'image')
            ->disabled(fn ($livewire) => $livewire instanceof EditRecord),

        TextInput::make('video_link')
            ->label('لینک ویدیو (فقط آپارات)')
            ->placeholder('ckv6gqv')
            ->visible(fn (Forms\Get $get) => $get('media_type') === 'video')
            ->required(fn (Forms\Get $get) => $get('media_type') === 'video')
            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                if ($state && str_contains($state, 'aparat.com')) {
                    if (preg_match('/aparat\.com\/v\/([a-zA-Z0-9]+)/', $state, $matches)) {
                        $set('media_path', $matches[1]);
                    } else {
                        $set('media_path', null);
                    }
                } else {
                    $set('media_path', null);
                }
            })
        //    ->rules(['starts_with:https://www.aparat.com/v/']) // ❌ حذف یا اصلاح این
            ->rules(['regex:/[a-zA-Z0-9]+/']), // ✅ این می‌تونه جایگزین مناسب‌تری باشه

        TextInput::make('media_path')
            ->label('کد ویدیو')
            ->hidden(),
        // TextInput::make('video_link')
        //     ->label('لینک ویدیو (آپارات / یوتیوب)')
        //     ->placeholder('https://www.aparat.com/v/abc123')
        //     ->visible(fn (Forms\Get $get) => $get('media_type') === 'video')
        //     ->required(fn (Forms\Get $get) => $get('media_type') === 'video')
        //     ->url()
        //     ->rules(['starts_with:https://www.aparat.com,https://www.youtube.com,https://youtu.be'])
        //     ->disabled(fn ($livewire) => $livewire instanceof EditRecord),

        Toggle::make('status')
            ->label('فعال')
            ->default(true),

        DateTimePicker::make('published_at')
            ->label('تاریخ انتشار')
            ->default(Carbon::now()) // مقدار پیش‌فرض: زمان حال
            ->jalali(),
            ]);
}

public static function mutateFormDataBeforeSave(array $data): array
{
    if (!empty($data['video_link']) && preg_match('/aparat\.com\/v\/([a-zA-Z0-9]+)/', $data['video_link'], $matches)) {
        $data['media_path'] = $matches[1];
    } else {
        $data['media_path'] = null;
    }

    return $data;
}

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable(),
            Tables\Columns\TextColumn::make('media_type')->label('نوع'),
            Tables\Columns\IconColumn::make('status')->boolean()->label('فعال'),
            // Tables\Columns\TextColumn::make('published_at')->label('تاریخ انتشار')->jalali(),
        ])
        ->defaultSort('published_at', 'desc')
        ->filters([])
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
            'index' => Pages\ListDailyMedia::route('/'),
            'create' => Pages\CreateDailyMedia::route('/create'),
            'edit' => Pages\EditDailyMedia::route('/{record}/edit'),
        ];
    }


}
