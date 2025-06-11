<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TagController extends Controller
{
    public function show($name)
{

    // پیدا کردن تگ بر اساس name
    $tag = Tag::where('name', $name)->firstOrFail();

    // گرفتن خبرهایی که این تگ رو دارند
    $newsList = $tag->news()
                    ->where('status', 1)
                    ->where('published_at', '<=', Carbon::now('Asia/Tehran'))
                    ->orderBy('published_at', 'desc')
                    ->get();
          


    return view('customer.news.tags', compact('tag', 'newsList'));
}


}
