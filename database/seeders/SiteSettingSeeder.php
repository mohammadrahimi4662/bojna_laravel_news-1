<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!SiteSetting::exists()) {
            SiteSetting::create([
                'logo_type' => 'text',
                'logo_text' => 'سایت خبری بحنا',
                'footer_about' => 'کلیه حقوق محفوظ است. سایت خبری بجنا در خدمت تمام هم شهریان عزیز بجنوردی...',
                'footer_social_links' => [
                    ['platform' => 'تلگرام', 'url' => 't.me/bojna'],
                    ['platform' => 'ایتا', 'url' => 'eitaa.com/bojna_ir'],
                    ['platform' => 'روبیکا', 'url' => 'rubika.ir/bojna_boj'],
                    ['platform' => 'اینستاگرام', 'url' => 'instagram.com/bojna.ir'],
                ],
            ]);
        }
    }
}
