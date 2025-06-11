<?php

namespace App\Filament\Resources\DailyMediaResource\Pages;

use App\Filament\Resources\DailyMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyMedia extends EditRecord
{
    protected static string $resource = DailyMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // اگر نوع رسانه تصویر باشد
        if ($data['media_type'] === 'image') {
            $data['image_upload'] = $data['media_path'];
        }

        // اگر نوع رسانه ویدیو باشد
        if ($data['media_type'] === 'video') {
            $data['video_link'] = $data['media_path'];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // چون فیلد media_path در ویرایش تغییر نمی‌کند، همان را نگه می‌داریم
        unset($data['image_upload'], $data['video_link']);
        return $data;
    }

}
