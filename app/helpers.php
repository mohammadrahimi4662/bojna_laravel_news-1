<?php

use Illuminate\Support\Str;

if (!function_exists('convertToEmbed')) {
    function convertToEmbed($url)
    {
        if (Str::contains($url, 'youtube.com') || Str::contains($url, 'youtu.be')) {
            // یوتیوب
            preg_match('/(youtu\.be\/|v=)([^\&\?\/]+)/', $url, $matches);
            $videoId = $matches[2] ?? null;
            if ($videoId) {
                return 'https://www.youtube.com/embed/' . $videoId;
            }
        } elseif (Str::contains($url, 'aparat.com')) {
            // آپارات
            preg_match('/\/video\/video\/embed\/(\w+)/', $url, $matches);
            if (isset($matches[1])) {
                return 'https://www.aparat.com/video/video/embed/' . $matches[1];
            }

            // لینک عادی آپارات -> استخراج کد
            preg_match('/\/v\/(\w+)/', $url, $matches);
            if (isset($matches[1])) {
                return 'https://www.aparat.com/video/video/embed/' . $matches[1];
            }
        }

        // لینک عادی بدون تغییر
        return $url;
    }
}
