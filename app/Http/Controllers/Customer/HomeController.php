<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DailyMedia;
use App\Models\Message;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function home(){
    //     $sliders = News::where('position', 'slider')
    //     ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
    //     ->orderBy('published_at', 'desc')
    //     ->get();


    //     $leftSliderNews = News::where('position', 'slider_side')
    //     ->where('status', 1)
    //     ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
    //     ->orderBy('published_at', 'desc')
    //     ->take(2)
    //     ->get();

    // $bottomSliderNews = News::where('position', 'slider_bottom')
    //     ->where('status', 1)
    //     ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
    //     ->orderBy('published_at', 'desc')
    //     ->take(4)
    //     ->get();

    // $messages = Message::where('status', true)
    //     ->where('published_at', '<=', now())
    //     ->latest()
    //     ->take(2)
    //     ->get();

    // $setting = SiteSetting::first();

    // $socials = json_decode($setting->footer_social_links, true);

    // اضافه کردن https:// به لینک‌هایی که ندارند (اختیاری ولی توصیه‌شده)
    // foreach ($socials as &$social) {
    //     if (!Str::startsWith($social['url'], ['http://', 'https://'])) {
    //         $social['url'] = 'https://' . $social['url'];
    //     }
    // }

        $media_video = DailyMedia::where('status', true)
            ->where(function ($query) {
                $query->whereNotNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->where('media_type', 'video')
            ->orderByDesc('published_at')
            ->first();

        $media_image = DailyMedia::where('status', true)
            ->where(function ($query) {
                $query->whereNotNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->where('media_type', 'image')
            ->orderByDesc('published_at')
            ->first();


    return view('customer.home', compact('media_image', 'media_video'));
    }
}
