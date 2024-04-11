<aside class="main-sidebar sidebar-dark-primary elevation-4 text-sm">
    <a class="brand-link" href="">
        <img class="brand-image" src="{{ url('resources/images/logo-admin.png') }}" alt="Logo">
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview"
                role="menu" data-accordion="false">

                {{-- Bảng điều khiển --}}
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}"
                        class="nav-link {{ session('module_active') === 'dashboard' ? 'active' : '' }}" href=""
                        title="{{ config('admin.dashboard.name') }}">
                        <i class="nav-icon text-sm fas fa-tachometer-alt"></i>
                        <p>{{ config('admin.dashboard.name') }}</p>
                    </a>
                </li>

                {{-- Sản phẩm --}}
                @if (config('admin.san-pham.active') === true)
                    @php
                        $type = config('admin.san-pham.type');
                        $sessionModule = session('module_active');
                        $conditionMenu = $sessionModule === $type ? true : false;
                        $lv1 = '-1';
                        $lv2 = '-2';
                        $lv3 = '-3';
                        $lv4 = '-4';
                        $tag = '-tag';
                    @endphp
                    <li
                        class="nav-item has-treeview menu-group {{ $sessionModule === $type || $sessionModule === $type . $tag || $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'menu-open' : '' }}">
                        <a class="nav-link {{ $sessionModule === $type || $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'active' : '' }}"
                            title="{{ config('admin.' . $type . '.name') }}">
                            <i class="nav-icon text-sm fa-solid fa-burger"></i>
                            <p>
                                {{ config('admin.' . $type . '.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (config('admin.' . $type . '.category.active') === true)
                                <li class="nav-item has-treeview {{ $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'menu-open' : '' }}"
                                    href="#" title="{{ config('admin.' . $type . '.category.name') }}">
                                    <a class="nav-link {{ $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'active' : '' }}"
                                        href="#" title="{{ config('admin.' . $type . '.category.name') }}">
                                        <i class="nav-icon text-sm fas fa-boxes"></i>
                                        <p>
                                            {{ config('admin.' . $type . '.category.name') }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        {{-- Category 1 --}}
                                        @if (config('admin.' . $type . '.category.category1.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_product1') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv1 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category1.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category1.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 2 --}}
                                        @if (config('admin.' . $type . '.category.category2.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_product2') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv2 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category2.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category2.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 3 --}}
                                        @if (config('admin.' . $type . '.category.category3.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_product3') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv3 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category3.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category3.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 4 --}}
                                        @if (config('admin.' . $type . '.category.category4.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_product4') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv4 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category4.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category4.name') }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if (config('admin.' . $type . '.size') === true)
                                <li class="nav-item">
                                    <a class="nav-link" href="" title="Size">
                                        <i class="nav-icon text-sm fas fa-boxes"></i>
                                        <p>Size</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.' . $type . '.color') === true)
                                <li class="nav-item">
                                    <a class="nav-link" href="" title="Màu sắc">
                                        <i class="nav-icon text-sm fas fa-boxes"></i>
                                        <p>Màu sắc</p>
                                    </a>
                                </li>
                            @endif

                            {{-- Tag product --}}
                            @if (config('admin.' . $type . '.tag.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ $sessionModule === $type . $tag ? 'active' : '' }}"
                                        href="{{ route('admin.tag_product') }}"
                                        title="{{ config('admin.' . $type . '.tag.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.' . $type . '.tag.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link {{ $sessionModule === $type ? 'active' : '' }}"
                                    href="{{ route('admin.product') }}" title="Sản phẩm">
                                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                    <p>Sản phẩm</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Tin tức --}}
                @if (config('admin.tin-tuc.active') === true)
                    @php
                        $type = config('admin.tin-tuc.type');
                        $sessionModule = session('module_active');
                        $lv1 = '-1';
                        $lv2 = '-2';
                        $lv3 = '-3';
                        $lv4 = '-4';
                    @endphp
                    <li
                        class="nav-item has-treeview menu-group {{ $sessionModule === $type || $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'menu-open' : '' }}">
                        <a class="nav-link {{ $sessionModule === $type || $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'active' : '' }}"
                            title="{{ config('admin.' . $type . '.name') }}">
                            <i class="nav-icon text-sm fa-solid fa-newspaper"></i>
                            <p>
                                {{ config('admin.' . $type . '.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (config('admin.' . $type . '.category.active') === true)
                                <li class="nav-item has-treeview {{ $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'menu-open' : '' }}"
                                    href="#" title="{{ config('admin.' . $type . '.category.name') }}">
                                    <a class="nav-link {{ $sessionModule === $type . $lv1 || $sessionModule === $type . $lv2 || $sessionModule === $type . $lv3 || $sessionModule === $type . $lv4 ? 'active' : '' }}"
                                        title="{{ config('admin.' . $type . '.name') }}">
                                        <i class="nav-icon text-sm fas fa-boxes"></i>
                                        <p>
                                            {{ config('admin.' . $type . '.category.name') }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        {{-- Category 1 --}}
                                        @if (config('admin.' . $type . '.category.category1.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_news1') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv1 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category1.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category1.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 2 --}}
                                        @if (config('admin.' . $type . '.category.category2.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_news2') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv2 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category2.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category2.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 3 --}}
                                        @if (config('admin.' . $type . '.category.category3.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_news3') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv3 ? 'active' : '' }}"
                                                    title="{{ config('admin.' . $type . '.category.category3.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category3.name') }}
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Category 4 --}}
                                        @if (config('admin.' . $type . '.category.category4.active') === true)
                                            <li class="nav-item">
                                                <a href="{{ route('admin.category_news4') }}"
                                                    class="nav-link {{ $sessionModule === $type . $lv4 ? 'active' : '' }}"
                                                    href=""
                                                    title="{{ config('admin.' . $type . '.category.category4.name') }}">
                                                    <i
                                                        class="nav-icon text-sm far fa-caret-square-right"></i>{{ config('admin.' . $type . '.category.category4.name') }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ $sessionModule === $type ? 'active' : '' }}"
                                    href="{{ url('admin/news') }}" title="Tin tức">
                                    <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                    <p>Tin tức</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Bài viết không cấp --}}
                @if (config('admin.post.active') === true)
                    @php
                        $nameStr = 'post-';
                        $sessionModule = session('module_active');
                        $conditionMenu =
                            $sessionModule === $nameStr . config('admin.post.tieu-chi.type') ||
                            $sessionModule === $nameStr . config('admin.post.chinh-sach.type') ||
                            $sessionModule === $nameStr . config('admin.post.hinh-thuc-thanh-toan.type')
                                ? true
                                : false;
                    @endphp
                    <li class="nav-item has-treeview menu-group {{ $conditionMenu === true ? 'menu-open' : '' }}">
                        <a class="nav-link {{ $conditionMenu === true ? 'active' : '' }}"
                            title="{{ config('admin.post.name') }}">
                            <i class="nav-icon text-sm fa-solid fa-book"></i>
                            <p>
                                {{ config('admin.post.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- Tiêu chí --}}
                            @if (config('admin.post.tieu-chi.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ $sessionModule === $nameStr . config('admin.post.tieu-chi.type') ? 'active' : '' }}"
                                        href="{{ route('admin.post', ['type' => config('admin.post.tieu-chi.type')]) }}"
                                        title="{{ config('admin.post.tieu-chi.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.post.tieu-chi.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            {{-- Chính sách --}}
                            @if (config('admin.post.chinh-sach.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ $sessionModule === $nameStr . config('admin.post.chinh-sach.type') ? 'active' : '' }}"
                                        href="{{ route('admin.post', ['type' => config('admin.post.chinh-sach.type')]) }}"
                                        title="{{ config('admin.post.chinh-sach.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.post.chinh-sach.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            {{-- Hình thức thanh toán --}}
                            @if (config('admin.post.hinh-thuc-thanh-toan.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ $sessionModule === $nameStr . config('admin.post.hinh-thuc-thanh-toan.type') ? 'active' : '' }}"
                                        href="{{ route('admin.post', ['type' => config('admin.post.hinh-thuc-thanh-toan.type')]) }}"
                                        title="{{ config('admin.post.hinh-thuc-thanh-toan.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.post.hinh-thuc-thanh-toan.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Danh sách đơn hàng --}}
                @if (config('admin.order.active') === true)
                    <li class="nav-item">
                        <a class="nav-link {{ session('module_active') === 'order_index' ? 'active' : '' }}"
                            href="{{ route('admin.order') }}" title="{{ config('admin.order.name') }}">
                            <i class="nav-icon text-sm fas fa-shopping-bag"></i>
                            <p>{{ config('admin.order.name') }}</p>
                        </a>
                    </li>
                @endif

                {{-- Đăng ký nhận tin --}}
                @if (config('admin.message.active') === true)
                    <li
                        class="nav-item has-treeview {{ session('module_active') === 'newsletter_index' || session('module_active') === 'newsletter_create' ? 'menu-open' : '' }}">
                        <a class="nav-link {{ session('module_active') === 'newsletter_index' || session('module_active') === 'newsletter_create' ? 'active' : '' }}"
                            href="#" title="{{ config('admin.message.name') }}">
                            <i class="nav-icon text-sm fas fa-envelope"></i>
                            <p>
                                {{ config('admin.message.name') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (config('admin.message.newsletter.active') === true)
                                <li class="nav-item ">
                                    <a class="nav-link {{ session('module_active') === 'newsletter_index' || session('module_active') === 'newsletter_create' ? 'active' : '' }}"
                                        href="{{ route('admin.newsletter.index') }}"
                                        title="{{ config('admin.message.newsletter.name') }}"><i
                                            class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.message.newsletter.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Module photo --}}
                @if (config('admin.photo.active') === true)
                    <li
                        class="nav-item has-treeview menu-group {{ session('module_active') === 'slideshow_index' || session('module_active') === 'slideshow_create' || session('module_active') === 'partner_index' || session('module_active') === 'partner_create' || session('module_active') === 'social_footer_index' || session('module_active') === 'social_footer_create' || session('module_active') === 'logo_create' || session('module_active') === 'watermark_product_create' || session('module_active') === 'favicon_create' ? 'menu-open' : '' }}">
                        <a class="nav-link {{ session('module_active') === 'slideshow_index' || session('module_active') === 'slideshow_create' || session('module_active') === 'partner_index' || session('module_active') === 'partner_create' || session('module_active') === 'social_footer_index' || session('module_active') === 'social_footer_create' || session('module_active') === 'logo_create' || session('module_active') === 'watermark_product_create' || session('module_active') === 'favicon_create' ? 'active' : '' }}"
                            title="{{ config('admin.photo.name') }}">
                            <i class="nav-icon text-sm fas fa-photo-video"></i>
                            <p>
                                {{ config('admin.photo.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if (config('admin.photo.slideshow.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'slideshow_index' || session('module_active') === 'slideshow_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.slideshow.index') }}"
                                        title="{{ config('admin.photo.slideshow.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.slideshow.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.partner.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'partner_index' || session('module_active') === 'partner_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.partner.index') }}"
                                        title="{{ config('admin.photo.partner.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.partner.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.social_footer.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'social_footer_index' || session('module_active') === 'social_footer_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.social_footer.index') }}"
                                        title="{{ config('admin.photo.social_footer.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.social_footer.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.logo.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'logo_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.logo') }}"
                                        title="{{ config('admin.photo.logo.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.logo.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.favicon.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'favicon_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.favicon') }}"
                                        title="{{ config('admin.photo.favicon.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.favicon.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.watermark_product.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'watermark_product_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.watermark_product') }}"
                                        title="{{ config('admin.photo.watermark_product.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.watermark_product.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.photo.watermark_news.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'watermark_news_create' ? 'active' : '' }}"
                                        href="{{ route('admin.photo.watermark_news') }}"
                                        title="{{ config('admin.photo.watermark_news.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.photo.watermark_news.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Module video --}}
                @if (config('admin.video.active') === true)
                    <li class="nav-item has-treeview menu-group {{ session('module_active') === 'video_multiple_index' || session('module_active') === 'video_multiple_create' || session('module_active') === 'video_static_index' ? 'menu-open' : '' }}"
                        title="{{ config('admin.video.name') }}">
                        <a class="nav-link {{ session('module_active') === 'video_multiple_index' || session('module_active') === 'video_multiple_create' || session('module_active') === 'video_static_index' ? 'active' : '' }}"
                            title="{{ config('admin.video.name') }}">
                            <i class="nav-icon text-sm fa-solid fa-video"></i>
                            <p>
                                {{ config('admin.video.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (config('admin.video.video_multiple.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'video_multiple_index' || session('module_active') === 'video_multiple_create' ? 'active' : '' }}"
                                        href="{{ route('admin.video.video_multiple.index') }}"
                                        title="{{ config('admin.video.video_multiple.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.video.video_multiple.name') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if (config('admin.video.video_static.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'video_static_index' ? 'active' : '' }}"
                                        href="{{ route('admin.video.video_static.index') }}"
                                        title="{{ config('admin.video.video_static.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.video.video_static.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Module place --}}
                @if (config('admin.place.active') === true)
                    <li
                        class="nav-item has-treeview menu-group {{ session('module_active') === 'city_index' || session('module_active') === 'city_create' || session('module_active') === 'district_index' || session('module_active') === 'district_create' || session('module_active') === 'ward_index' || session('module_active') === 'ward_create' ? 'menu-open' : '' }}">
                        <a class="nav-link {{ session('module_active') === 'city_index' || session('module_active') === 'city_create' || session('module_active') === 'district_index' || session('module_active') === 'district_create' || session('module_active') === 'ward_index' || session('module_active') === 'ward_create' ? 'active' : '' }}"
                            title="{{ config('admin.place.name') }}">
                            <i class="nav-icon text-sm fas fa-building"></i>
                            <p>
                                {{ config('admin.place.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if (config('admin.place.city.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'city_index' || session('module_active') === 'city_create' ? 'active' : '' }}"
                                        href="{{ route('admin.place.city.index', ['type' => config('admin.place.city.type')]) }}"
                                        title="{{ config('admin.place.city.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.place.city.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.place.district.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'district_index' || session('module_active') === 'district_create' ? 'active' : '' }}"
                                        href="{{ route('admin.place.district.index', ['type' => config('admin.place.district.type')]) }}"
                                        title="{{ config('admin.place.district.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.place.district.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.place.ward.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === 'ward_index' || session('module_active') === 'ward_create' ? 'active' : '' }}"
                                        href="{{ route('admin.place.ward.index', ['type' => config('admin.place.ward.type')]) }}"
                                        title="{{ config('admin.place.ward.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.place.ward.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Module page --}}
                @if (config('admin.page.active') === true)
                    <li
                        class="nav-item has-treeview menu-group {{ session('module_active') === config('admin.page.gioi-thieu.type') || session('module_active') === config('admin.page.footer.type') || session('module_active') === config('admin.page.contact.type') || session('module_active') === config('admin.page.copyright.type') || session('module_active') === config('admin.page.slogan.type') ? 'menu-open' : '' }}">
                        <a class="nav-link {{ session('module_active') === config('admin.page.gioi-thieu.type') || session('module_active') === config('admin.page.footer.type') || session('module_active') === config('admin.page.contact.type') || session('module_active') === config('admin.page.copyright.type') || session('module_active') === config('admin.page.slogan.type') ? 'active' : '' }}"
                            title="{{ config('admin.page.name') }}">
                            <i class="nav-icon text-sm fas fa-bookmark"></i>
                            <p>
                                {{ config('admin.page.name') }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if (config('admin.page.gioi-thieu.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === config('admin.page.gioi-thieu.type') ? 'active' : '' }}"
                                        href="{{ route('admin.page', ['type' => config('admin.page.gioi-thieu.type')]) }}"
                                        title="{{ config('admin.page.gioi-thieu.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.page.gioi-thieu.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.page.footer.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === config('admin.page.footer.type') ? 'active' : '' }}"
                                        href="{{ route('admin.page', ['type' => config('admin.page.footer.type')]) }}"
                                        title="{{ config('admin.page.footer.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.page.footer.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.page.contact.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === config('admin.page.contact.type') ? 'active' : '' }}"
                                        href="{{ route('admin.page', ['type' => config('admin.page.contact.type')]) }}"
                                        title="{{ config('admin.page.contact.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.page.contact.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.page.copyright.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === config('admin.page.copyright.type') ? 'active' : '' }}"
                                        href="{{ route('admin.page', ['type' => config('admin.page.copyright.type')]) }}"
                                        title="{{ config('admin.page.copyright.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.page.copyright.name') }}</p>
                                    </a>
                                </li>
                            @endif

                            @if (config('admin.page.slogan.active') === true)
                                <li class="nav-item">
                                    <a class="nav-link {{ session('module_active') === config('admin.page.slogan.type') ? 'active' : '' }}"
                                        href="{{ route('admin.page', ['type' => config('admin.page.slogan.type')]) }}"
                                        title="{{ config('admin.page.slogan.name') }}">
                                        <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                        <p>{{ config('admin.page.slogan.name') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Module seopage --}}
                @if (config('admin.seopage.active') === true)
                    @php
                        $name = config('admin.seopage.name');
                        $types = [
                            config('admin.seopage.home.type'),
                            config('admin.seopage.san-pham.type'),
                            config('admin.seopage.tin-tuc.type'),
                            config('admin.seopage.lien-he.type'),
                        ];
                        $sessionModule = session('module_active');
                        $nameStr = 'seopage';
                        $conditionMenu =
                            $sessionModule === $nameStr . config('admin.seopage.home.type') ||
                            $sessionModule === $nameStr . config('admin.seopage.san-pham.type') ||
                            $sessionModule === $nameStr . config('admin.seopage.tin-tuc.type') ||
                            $sessionModule === $nameStr . config('admin.seopage.lien-he.type')
                                ? true
                                : false;
                    @endphp
                    <li class="nav-item has-treeview menu-group {{ $conditionMenu === true ? 'menu-open' : '' }}">
                        <a class="nav-link {{ $conditionMenu === true ? 'active' : '' }}"
                            title="{{ $name }}">
                            <i class="nav-icon text-sm fas fa-share-alt"></i>
                            <p>
                                {{ $name }}<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($types as $type)
                                @if (config('admin.seopage.' . $type . '.active') === true)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $sessionModule === $nameStr . config('admin.seopage.' . $type . '.type') ? 'active' : '' }}"
                                            href="{{ route('admin.seopage', ['type' => config('admin.seopage.' . $type . '.type')]) }}"
                                            title="{{ config('admin.seopage.' . $type . '.name') }}">
                                            <i class="nav-icon text-sm far fa-caret-square-right"></i>
                                            <p>{{ config('admin.seopage.' . $type . '.name') }}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                {{-- Module setting --}}
                <li class="nav-item">
                    <a class="nav-link {{ session('module_active') === 'setting_index' ? 'active' : '' }}"
                        href="{{ route('admin.setting') }}" title="{{ config('admin.setting.name') }}">
                        <i class="nav-icon text-sm fas fa-cogs"></i>
                        <p>{{ config('admin.setting.name') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
