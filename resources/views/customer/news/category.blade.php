@extends('customer.layouts.master-one-col')

@section('head-tag')
<link rel="stylesheet" href="{{ asset('assets/css/style-show.css') }}">

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
{{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style type="text/tailwindcss">
    @theme {
        --color-clifford: #da373d;
      }
</style> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@endsection

@section('content')
<div class="custom-responsive-row col-12 row">
    <div class="col-md-8 rounded" style="max-width: 800px; height: auto;">
        {{-- عنوان دسته‌بندی --}}
        {{-- <section class="feedback-section mb-2">
            <div class="feedback-box p-3">
                <h3 class="text-right mb-2">
                    <i class="fas fa-newspaper me-3"></i>
                    خبرهای مرتبط با دسته‌بندی: {{ $category->title }}
                </h3>
            </div>
        </section> --}}

        {{-- لیست اخبار --}}
        <section class="feedback-section shadow">
            <div class="feedback-box">
                @if(count($category->news) > 0)
                @foreach ($category->news as $news)
                <div class="news-card row align-items-center shadow-sm rounded-3 p-3 mb-4 bg-white">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid rounded-3 shadow-sm"
                            alt="تصویر خبر">
                    </div>
                    <div class="col-md-8">
                        <a href="{{ route('customer.news.show', $news) }}" class="text-decoration-none">
                            <div class="news-content">
                                <span class="badge bg-danger mb-2">{{ $news->category->title }}</span>
                                <h5 class="news-title text-dark">{{ $news->title }}</h5>
                                <p class="text-black text-justify">
                                    {{ Str::limit(trim(str_replace('&nbsp;', ' ', strip_tags($news->body))), 150, '[...]') }}
                                </p>
                                <div class="news-meta mt-3">
                                    <span class="news-date text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ jdate($news->published_at)->format('%d %B %Y') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                @else
                <p>خبری برای دسته‌بندی <span class="text-danger">{{ $category->title }}</span> یافت نشد!</p>
                @endif
            </div>
        </section>
    </div>



<!-- Sidebar -->
@include('customer.news.sidebar')
</div>

@endsection


@section('scripts')

@endsection
