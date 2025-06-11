<nav class="navbar navbar-expand-lg navbar-dark py-2">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        {{-- لوگو --}}
        @if($setting)
            @if($setting->logo_type == 'image')
                <a class="navbar-brand me-3" href="{{ env('APP_URL') }}">
                    <img src="{{ env('APP_URL') . '/storage/' . $setting->logo_image }}" alt="لوگو" style="height: 40px;">
                </a>
            @else
                <a class="navbar-brand me-3" href="{{ env('APP_URL') }}">
                    <p class="mb-0 text-white">{{ $setting->logo_text }}</p>
                </a>
            @endif
        @endif

        {{-- دکمه منو در موبایل --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="تبدیل ناوبری">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- منو و فرم جستجو --}}
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- آیتم خانه --}}
                @php
                    $isHomeActive = request()->routeIs('customer.home') ||
                                    request()->routeIs('customer.news.tags') ||
                                    request()->routeIs('customer.search');
                @endphp
                <li class="nav-item">
                    <a class="nav-link {{ $isHomeActive ? 'active' : '' }}" href="{{ route('customer.home') }}">
                        خانه
                    </a>
                </li>

                {{-- دسته‌بندی‌ها --}}
                @foreach($categories as $menu)
                    @php
                        $isActiveCategory =
                            (request()->routeIs('customer.category.show') &&
                             request()->route('category') &&
                             request()->route('category')->slug === $menu->slug) ||

                            (request()->routeIs('customer.news.show') &&
                             request()->route('news') &&
                             optional(request()->route('news')->category)->slug === $menu->slug);
                    @endphp

                    <li class="nav-item">
                        <a class="nav-link {{ $isActiveCategory ? 'active' : '' }}"
                            href="{{ route('customer.category.show', $menu->slug) }}">
                            {{ $menu->title }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- فرم جستجو --}}
            <form action="{{ route('customer.search') }}" method="GET" role="search" id="search-form"
                  class="form-search-header d-flex align-items-center ms-lg-3 mt-2 mt-lg-0">
                <input type="text" name="q" class="form-control border-0 bg-transparent"
                       placeholder="جستجو..." value="{{ request('q') }}" id="search-input"
                       style="box-shadow: none;">
                <button type="submit" class="btn text-white" style="background-color: #dc3545; border-radius: 50px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.getElementById('search-form').addEventListener('submit', function(e) {
        let input = document.getElementById('search-input').value.trim();
        if (input.length === 0) {
            e.preventDefault();
            alert("لطفاً عبارتی برای جستجو وارد کنید.");
        }
    });
</script>
