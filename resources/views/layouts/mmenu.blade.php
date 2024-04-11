<div class="menu-res">
    <div class="menu-bar-res">
        <a id="hamburger" href="#menu" title="Menu"><span></span></a>
        <div class="search-res">
            <p class="icon-search-cus transition"><i class="fa-solid fa-magnifying-glass"></i></p>
            <div class="search-grid w-clear">
                <input type="text" name="keyword-res" id="keyword-res" placeholder="Tìm kiếm..."
                    data-url="{{ route('search') }}"
                    value="{{ !empty(request()->keyword) ? request()->keyword : '' }}" />
                <p class="icon-seach-res"><i class="fa-solid fa-magnifying-glass"></i></p>
            </div>
        </div>
    </div>
    <nav id="menu">
        <ul>
            <li>
                <a href="{{ url('/') }}"
                    class="{{ !empty($currentPath) && $currentPath == '/' ? 'active' : '' }} transition" title="Home">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                    class="transition {{ strpos($currentPath, 'gioi-thieu') !== false ? 'active' : '' }}"
                    title="Giới thiệu">
                    Giới thiệu
                </a>
            </li>
            <li>
                <a href="{{ route('product') }}"
                    class="transition {{ strpos($currentPath, 'san-pham') !== false ? 'active' : '' }}"
                    title="Sản phẩm">
                    Sản phẩm
                </a>
                @if (count($categoryProduct1) > 0)
                    <ul class="menu-category-product1">
                        @foreach ($categoryProduct1 as $v1)
                            @php
                                $slug1 = $helper->generateNameId($v1->title, $v1->id);
                                $categoryProduct2 = App\Models\Admin\CategoryProduct::where(
                                    'type',
                                    config('admin.san-pham.type'),
                                )
                                    ->where('level', 2)
                                    ->where('id_parent', $v1->id)
                                    ->whereRaw('find_in_set("hienthi", status)')
                                    ->orderBy('num', 'ASC')
                                    ->orderBy('id', 'ASC')
                                    ->get();
                            @endphp
                            <li>
                                <a href="{{ route('product', ['slug' => $slug1]) }}" title="{{ $v1->title }}">
                                    {{ $v1->title }}
                                </a>
                                @if (count($categoryProduct2) > 0)
                                    <ul class="menu-category-product2">
                                        @foreach ($categoryProduct2 as $v2)
                                            @php
                                                $slug2 = $helper->generateNameId($v2->title, $v2->id);
                                                $categoryProduct3 = App\Models\Admin\CategoryProduct::where(
                                                    'type',
                                                    config('admin.san-pham.type'),
                                                )
                                                    ->where('level', 3)
                                                    ->where('id_parent', $v2->id)
                                                    ->whereRaw('find_in_set("hienthi", status)')
                                                    ->orderBy('num', 'ASC')
                                                    ->orderBy('id', 'ASC')
                                                    ->get();
                                            @endphp
                                            <li>
                                                <a href="{{ route('product', ['slug' => $slug2]) }}"
                                                    title="{{ $v2->title }}">
                                                    {{ $v2->title }}
                                                </a>
                                                @if (count($categoryProduct3) > 0)
                                                    <ul class="menu-category-product3">
                                                        @foreach ($categoryProduct3 as $v3)
                                                            @php
                                                                $slug3 = $helper->generateNameId($v3->title, $v3->id);
                                                                $categoryProduct4 = App\Models\Admin\CategoryProduct::where(
                                                                    'type',
                                                                    config('admin.san-pham.type'),
                                                                )
                                                                    ->where('level', 4)
                                                                    ->where('id_parent', $v3->id)
                                                                    ->whereRaw('find_in_set("hienthi", status)')
                                                                    ->orderBy('num', 'ASC')
                                                                    ->orderBy('id', 'ASC')
                                                                    ->get();
                                                            @endphp
                                                            <li>
                                                                <a href="{{ route('product', ['slug' => $slug3]) }}"
                                                                    title="{{ $v3->title }}">
                                                                    {{ $v3->title }}
                                                                </a>
                                                                @if (count($categoryProduct4) > 0)
                                                                    <ul class="menu-category-product4">
                                                                        @foreach ($categoryProduct4 as $v4)
                                                                            @php
                                                                                $slug4 = $helper->generateNameId(
                                                                                    $v4->title,
                                                                                    $v4->id,
                                                                                );
                                                                            @endphp
                                                                            <li>
                                                                                <a href="{{ route('product', ['slug' => $slug4]) }}"
                                                                                    title="{{ $v4->title }}">
                                                                                    {{ $v4->title }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
            <li>
                <a href="{{ route('news') }}"
                    class="transition {{ strpos($currentPath, 'tin-tuc') !== false ? 'active' : '' }}" title="Tin tức">
                    Tin tức
                </a>
                @if (count($categoryNews1) > 0)
                    <ul class="menu-category-news1">
                        @foreach ($categoryNews1 as $v1)
                            @php
                                $slug1 = $helper->generateNameId($v1->title, $v1->id);
                                $categoryNews2 = App\Models\Admin\CategoryNews::where(
                                    'type',
                                    config('admin.tin-tuc.type'),
                                )
                                    ->where('level', 2)
                                    ->where('id_parent', $v1->id)
                                    ->whereRaw('find_in_set("hienthi", status)')
                                    ->orderBy('num', 'ASC')
                                    ->orderBy('id', 'ASC')
                                    ->get();
                            @endphp
                            <li>
                                <a href="{{ route('news', ['slug' => $slug1]) }}" title="{{ $v1->title }}">
                                    {{ $v1->title }}
                                </a>
                                @if (count($categoryNews2) > 0)
                                    <ul class="menu-category-news2">
                                        @foreach ($categoryNews2 as $v2)
                                            @php
                                                $slug2 = $helper->generateNameId($v2->title, $v2->id);
                                                $categoryNews3 = App\Models\Admin\CategoryNews::where(
                                                    'type',
                                                    config('admin.tin-tuc.type'),
                                                )
                                                    ->where('level', 3)
                                                    ->where('id_parent', $v2->id)
                                                    ->whereRaw('find_in_set("hienthi", status)')
                                                    ->orderBy('num', 'ASC')
                                                    ->orderBy('id', 'ASC')
                                                    ->get();
                                            @endphp
                                            <li>
                                                <a href="{{ route('news', ['slug' => $slug2]) }}"
                                                    title="{{ $v2->title }}">
                                                    {{ $v2->title }}
                                                </a>
                                                @if (count($categoryNews3) > 0)
                                                    <ul class="menu-category-news3">
                                                        @foreach ($categoryNews3 as $v3)
                                                            @php
                                                                $slug3 = $helper->generateNameId($v3->title, $v3->id);
                                                                $categoryNews4 = App\Models\Admin\CategoryNews::where(
                                                                    'type',
                                                                    config('admin.tin-tuc.type'),
                                                                )
                                                                    ->where('level', 4)
                                                                    ->where('id_parent', $v3->id)
                                                                    ->whereRaw('find_in_set("hienthi", status)')
                                                                    ->orderBy('num', 'ASC')
                                                                    ->orderBy('id', 'ASC')
                                                                    ->get();
                                                            @endphp
                                                            <li>
                                                                <a href="{{ route('news', ['slug' => $slug3]) }}"
                                                                    title="{{ $v3->title }}">
                                                                    {{ $v3->title }}
                                                                </a>
                                                                @if (count($categoryNews4) > 0)
                                                                    <ul class="menu-category-news4">
                                                                        @foreach ($categoryNews4 as $v4)
                                                                            @php
                                                                                $slug4 = $helper->generateNameId(
                                                                                    $v4->title,
                                                                                    $v4->id,
                                                                                );
                                                                            @endphp
                                                                            <li>
                                                                                <a href="{{ route('news', ['slug' => $slug4]) }}"
                                                                                    title="{{ $v4->title }}">
                                                                                    {{ $v4->title }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
            <li>
                <a href="{{ route('contact') }}"
                    class="transition {{ strpos($currentPath, 'lien-he') !== false ? 'active' : '' }}" title="Liên hệ">
                    Liên hệ
                </a>
            </li>
        </ul>
    </nav>
</div>
