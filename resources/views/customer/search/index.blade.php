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

        @php
        $totalResults = $newsResults->count() + $categoryResults->count() + $tagResults->count();
        @endphp

        <div class="container">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-3">
                        نتایج جستجو برای:
                        <span class="text-danger">"{{ $query }}"</span>
                    </h4>

                    <h6 class="text-muted mb-4">
                        تعداد کل نتایج یافت‌شده:
                        <span class="text-dark fw-bold">{{ $totalResults }}</span>
                    </h6>

                    {{-- اخبار --}}
                    <div class="mb-4">
                        <h5 class="d-flex justify-content-between align-items-center border-bottom pb-2">
                            <span>اخبار</span>
                            <span class="badge bg-danger">{{ $newsResults->count() }}</span>
                        </h5>
                        @if($newsResults->count())
                        <ul class="list-group list-group-flush">
                            @foreach($newsResults as $news)
                            <li class="list-group-item">
                                <a href="{{ route('customer.news.show', $news->title) }}" class="text-decoration-none">
                                    {{ $news->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted mt-2">موردی یافت نشد.</p>
                        @endif
                    </div>

                    {{-- دسته‌بندی‌ها --}}
                    <div class="mb-4">
                        <h5 class="d-flex justify-content-between align-items-center border-bottom pb-2">
                            <span>دسته‌بندی‌ها</span>
                            <span class="badge bg-danger">{{ $categoryResults->count() }}</span>
                        </h5>
                        @if($categoryResults->count())
                        <ul class="list-group list-group-flush">
                            @foreach($categoryResults as $category)
                            <li class="list-group-item">
                                <a href="{{ route('customer.category.show', $category->slug) }}"
                                    class="text-decoration-none">
                                    {{ $category->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted mt-2">موردی یافت نشد.</p>
                        @endif
                    </div>

                    {{-- تگ‌ها --}}
                    <div class="mb-4">
                        <h5 class="d-flex justify-content-between align-items-center border-bottom pb-2">
                            <span>برچسب‌ها</span>
                            <span class="badge bg-danger">{{ $tagResults->count() }}</span>
                        </h5>
                        @if($tagResults->count())
                        <ul class="list-group list-group-flush">
                            @foreach($tagResults as $tag)
                            <li class="list-group-item">
                                <a href="{{ route('customer.news.tags', $tag->name) }}" class="text-decoration-none">
                                    {{ $tag->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted mt-2">موردی یافت نشد.</p>
                        @endif
                    </div>


                </div>
            </div>
        </div>

    </div>


    <!-- Sidebar -->
    @include('customer.news.sidebar')
</div>





@endsection


@section('scripts')

@endsection
