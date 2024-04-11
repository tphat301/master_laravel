@section('head')
    @parent
    @include('layouts.head')
@endsection
@section('seo')
    @parent
    @include('layouts.seo')
@endsection

@extends('welcome')

@section('title', !empty($seoPage->title) ? $seoPage->title : '')

@section('slideshow')
    @parent
    @include('layouts.slide')
@endsection

@section('content')

    @if (count($prdBestSeller) > 0)
        <section class="prd-hot">
            <div class="wrap-content">
                <h2 class="prd-hot__title">
                    Sản phẩm bán chạy
                </h2>
                <div class="owl-prd-hot" data-aos="fade-up" data-aos-duration="1000">
                    <div class="owl-page owl-carousel owl-theme" data-xsm-items="2:10" data-sm-items="2:10" data-md-items="3:10"
                        data-lg-items="4:10" data-xlg-items="5:10" data-rewind="1" data-autoplay="1" data-loop="0"
                        data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500"
                        data-autoplayspeed="3500" data-dots="0" data-nav="1"
                        data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>"
                        data-navcontainer=".control-prd-hot">
                        @foreach ($prdBestSeller as $v)
                            @php
                                $nameId = $helper->generateNameId($v->title, $v->id);
                            @endphp
                            <div class="prd-hot-item">
                                <div class="pro-hot-img">
                                    <a href="{{ route('product', ['slug' => $nameId]) }}" class="scale-img"
                                        title="{!! $v->title !!}">
                                        <img loading="lazy"
                                            src="{{ !empty($v->photo1) ? asset('upload/product/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                            alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                                    </a>
                                </div>
                                <h3 class="pro-hot-name">
                                    <a href="{{ route('product', ['slug' => $nameId]) }}" class="text-split"
                                        title="{!! $v->title !!}">
                                        {!! $v->title !!}
                                    </a>
                                </h3>
                                <p class="pro-hot-price">
                                    @if (!empty($v->discount))
                                        <span class="sale-price">
                                            {{ number_format($v->sale_price, 0, ',', '.') . 'đ' }}
                                        </span>
                                        <span class="regular-price">
                                            {{ number_format($v->regular_price, 0, ',', '.') . 'đ' }}
                                        </span>
                                        <span class="discount">
                                            {{ '-' . $v->discount . '%' }}
                                        </span>
                                    @else
                                        <span
                                            class="sale-price">{{ !empty($v->sale_price) ? number_format($v->sale_price, 0, ',', '.') : 'Liên hệ' }}</span>
                                    @endif
                                </p>
                                @if (!empty($v->sale_price))
                                    <p class="pro-hot-cart">
                                        <a href="{{ route('order.add', ['id' => $v->id]) }}"
                                            class="btn-cart text-decoration-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                                            </svg>
                                        </a>
                                    </p>
                                @endif
                                <p class="pro-hot-ticker">
                                    {{ $helper->isStatus('banchay', explode(',', $v->status)) ? 'hot' : '' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="control-prd-hot control-owl transition"></div>
                </div>
            </div>
        </section>
    @endif

    @if ($prdHot->count() > 0)
        <section class="prdhot">
            <div class="wrap-content">
                <h2 class="prdhot-title">
                    Sản phẩm nổi bật
                </h2>
                <div class="prdhot-list">
                    @foreach ($prdHot as $v)
                        @php
                            $nameId = $helper->generateNameId($v->title, $v->id);
                        @endphp
                        <div class="prdhot-item" data-aos="fade-up" data-aos-duration="1000">
                            <div class="prdhot-img">
                                <a href="{{ route('product', ['slug' => $nameId]) }}" class="scale-img"
                                    title="{!! $v->title !!}">
                                    <img loading="lazy" class="w-100"
                                        src="{{ !empty($v->photo1) ? asset('upload/product/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                        alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                                </a>
                            </div>
                            <h3 class="prdhot-name">
                                <a href="{{ route('product', ['slug' => $nameId]) }}" class="text-split"
                                    title="{!! $v->title !!}">
                                    {!! $v->title !!}
                                </a>
                            </h3>
                            <p class="prdhot-price">
                                @if (!empty($v->discount))
                                    <span class="sale-price">
                                        {{ number_format($v->sale_price, 0, ',', '.') . 'đ' }}
                                    </span>
                                    <span class="regular-price">
                                        {{ number_format($v->regular_price, 0, ',', '.') . 'đ' }}
                                    </span>
                                    <span class="discount">
                                        {{ '-' . $v->discount . '%' }}
                                    </span>
                                @else
                                    <span
                                        class="sale-price">{{ !empty($v->sale_price) ? number_format($v->sale_price, 0, ',', '.') : 'Liên hệ' }}</span>
                                @endif
                            </p>
                            @if (!empty($v->sale_price))
                                <p class="prdhot-cart">
                                    <a href="{{ route('order.add', ['id' => $v->id]) }}"
                                        class="btn-cart text-decoration-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                                        </svg>
                                    </a>
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="pagg">
                    {!! $prdHot->links() !!}
                </div>
            </div>
        </section>
    @endif

    @if (count($prdCategory1) > 0)
        @foreach ($prdCategory1 as $k1 => $v1)
            @php
                $prds = App\Models\Admin\Product::where('type', config('admin.san-pham.type'))
                    ->where('id_parent1', $v1->id)
                    ->whereRaw('find_in_set("noibat", status)')
                    ->whereRaw('find_in_set("hienthi", status)')
                    ->orderBy('num', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->paginate(10, '*', 'product' . $k1 + 1);
            @endphp
            <section class="prdhot">
                <div class="wrap-content">
                    <h2 class="prdhot-title">
                        {{ $v1->title }}
                    </h2>
                    <div class="prdthot-list" data-aos="fade-up" data-aos-duration="1000">
                        @foreach ($prds as $v)
                            @php
                                $nameId = $helper->generateNameId($v->title, $v->id);
                            @endphp
                            <div class="prdhot-item">
                                <div class="prdhot-img">
                                    <a href="{{ route('product', ['slug' => $nameId]) }}" class="scale-img"
                                        title="{!! $v->title !!}">
                                        <img loading="lazy" class="w-100"
                                            src="{{ !empty($v->photo1) ? asset('upload/product/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                            alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                                    </a>
                                </div>
                                <h3 class="prdhot-name">
                                    <a href="{{ route('product', ['slug' => $nameId]) }}" class="text-split"
                                        title="{!! $v->title !!}">
                                        {!! $v->title !!}
                                    </a>
                                </h3>
                                <p class="prdhot-price">
                                    @if (!empty($v->discount))
                                        <span class="sale-price">
                                            {{ number_format($v->sale_price, 0, ',', '.') . 'đ' }}
                                        </span>
                                        <span class="regular-price">
                                            {{ number_format($v->regular_price, 0, ',', '.') . 'đ' }}
                                        </span>
                                        <span class="discount">
                                            {{ '-' . $v->discount . '%' }}
                                        </span>
                                    @else
                                        <span
                                            class="sale-price">{{ !empty($v->sale_price) ? number_format($v->sale_price, 0, ',', '.') : 'Liên hệ' }}</span>
                                    @endif
                                </p>
                                @if (!empty($v->sale_price))
                                    <p class="prdhot-cart">
                                        <a href="{{ route('order.add', ['id' => $v->id]) }}"
                                            class="btn-cart text-decoration-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                                            </svg>
                                        </a>
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="pagg">
                        {!! $prds->links() !!}
                    </div>
                </div>
            </section>
        @endforeach
    @endif

    @if (count($prdCategory1) > 0)
        <section class="prdtab" data-aos="fade-up" data-aos-duration="1000">
            <div class="wrap-content">
                <h2 class="prdtab-title">
                    Sản phẩm nổi bật
                </h2>
                <ul class="prdtab-list">
                    <li>
                        <a class="prdtab-item" data-id="0" data-url="{{ route('api_product') }}" title="Tất cả">
                            Tất cả
                        </a>
                    </li>
                    @foreach ($prdCategory1 as $k1 => $v1)
                        <li>
                            <a class="prdtab-item" data-id="{{ $v1->id }}" data-url="{{ route('api_product') }}"
                                title="{{ $v1->title }}">
                                {{ $v1->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="load-api-prd"></div>
            </div>
        </section>
    @endif

    <section class="newsletter_index" data-aos="fade-up" data-aos-duration="1000">
        <div class="wrap-content">
            <h2 class="newsletter-title">ĐĂNG KÝ NHẬN TIN</h2>
            {!! Form::open([
                'name' => 'form-newsletter',
                'route' => ['newsletter'],
                'class' => ['validation-newsletter', 'form-newsletter'],
                'novalidate' => true,
            ]) !!}
            <div class="newsletter-group">
                <div class="newsletter-input">
                    <input type="text" class="form-control text-sm @error('fullname') is-invalid @enderror"
                        id="fullname-newsletter" name="dataNewsletter[fullname]" placeholder="Họ tên:"
                        value="{{ session('fullname') }}" />
                </div>
                @error('fullname')
                    <span class="text-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="newsletter-input">
                    <input type="number" class="form-control text-sm @error('phone') is-invalid @enderror"
                        id="phone-newsletter" name="dataNewsletter[phone]" value="{{ session('phone') }}"
                        placeholder="Số điện thoại:" />
                </div>
                @error('phone')
                    <span class="text-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="newsletter-input">
                <input type="email" class="form-control text-sm @error('email') is-invalid @enderror"
                    id="email-newsletter" name="dataNewsletter[email]" value="{{ session('email') }}"
                    placeholder="Email:" />
            </div>
            @error('email')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="newsletter-input">
                <input type="text" class="form-control text-sm @error('address') is-invalid @enderror"
                    id="address-newsletter" name="dataNewsletter[address]" placeholder="Địa chỉ:"
                    value="{{ session('address') }}">
            </div>
            @error('address')
                <span class="text-danger">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="newsletter-textarea">
                <textarea class="form-control text-sm" id="content-newsletter" name="dataNewsletter[content]"
                    placeholder="Nội dung:">{{ session('content') }}</textarea>
            </div>
            <div class="newsletter-button">
                <input type="submit" class="btn btn-sm btn-danger w-100" name="submit-newsletter" value="Đăng Ký Ngay">
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    @if (count($partner) > 0)
        <section class="wrap-partner" data-aos="fade-up" data-aos-duration="1000">
            <div class="wrap-content">
                <div class="title-main">
                    <span>
                        Đối tác khách hàng
                    </span>
                </div>
                <div class="owl-partner">
                    <div class="owl-page owl-carousel owl-theme" data-xsm-items="2:10" data-sm-items="3:10"
                        data-md-items="5:10" data-lg-items="5:10" data-xlg-items="7:10" data-rewind="1"
                        data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1"
                        data-smartspeed="500" data-autoplayspeed="3500" data-dots="0" data-nav="1"
                        data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>"
                        data-navcontainer=".control-partner">
                        @foreach ($partner as $v)
                            <div>
                                <a class="partner" href="{{ $v->link }}" target="_blank"
                                    title="{{ $v->title }}">
                                    <img loading="lazy" class="w-100"
                                        src="{{ !empty($v->photo) ? asset('upload/photo/' . $v->photo) : url('resources/images/noimage.png') }}"
                                        alt="{{ !empty($v->photo) ? $v->title : 'Noimage' }}" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="control-partner control-owl transition"></div>
                </div>
            </div>
        </section>
    @endif

    <section class="wrap-intro" data-aos="fade-up" data-aos-duration="1000">
        <div class="wrap-content">
            <div class="title-main">
                <span>
                    Video && tin tức
                </span>
            </div>
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <div class=" d-flex flex-wrap align-items-start justify-content-between ">
                        <div class="newshome-intro">
                            @php
                                $nameId = $helper->generateNameId($news->first()->title, $news->first()->id);
                            @endphp
                            <a class="pic-newshome-best scale-img newshome-best"
                                href="{{ route('news', ['slug' => $nameId]) }}" title="{{ $news->first()->title }}">
                                <img loading="lazy" class="w-100"
                                    src="{{ !empty($news->first()->photo1) ? asset('upload/news/' . $news->first()->photo1) : url('resources/images/noimage.png') }}"
                                    alt="{{ !empty($news->first()->photo1) ? $news->first()->title : 'Noimage' }}" />
                            </a>
                            <h3>
                                <a class="text-decoration-none name-newshome text-split"
                                    href="{{ route('news', ['slug' => $nameId]) }}" title="{{ $news->first()->title }}">
                                    {{ $news->first()->title }}
                                </a>
                            </h3>
                            <p class="time-newshome">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $news->first()->created_at)->format('d/m/Y') }}
                            </p>
                            <div class="desc-newshome text-split">
                                {!! htmlspecialchars_decode($news->first()->desc) !!}
                            </div>
                            <a href="#" class="btn_custom text-decoration-none" title="Xem thêm">
                                Xem thêm
                            </a>
                        </div>
                        <div class="newshome-scroll">
                            <div class="slick-v-3">
                                @foreach ($news as $k => $v)
                                    @php
                                        $nameId = $helper->generateNameId($v->title, $v->id);
                                    @endphp
                                    @if ($k > 0)
                                        <div class="news-slick-box">
                                            <div class="news-slick">
                                                <a class="img scale-img" href="{{ route('news', ['slug' => $nameId]) }}"
                                                    title="{{ $v->title }}">
                                                    <img loading="lazy" class="w-100"
                                                        src="{{ !empty($v->photo1) ? asset('upload/news/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                                        alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                                                </a>
                                                <div class="info">
                                                    <h3>
                                                        <a class="name-newshome text-split text-decoration-none"
                                                            href="{{ route('news', ['slug' => $nameId]) }}"
                                                            title="{{ $v->title }}">
                                                            {{ $v->title }}
                                                        </a>
                                                    </h3>
                                                    <div class="desc-newshome desc-home-cl text-split">
                                                        {!! htmlspecialchars_decode($v->desc) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="videohome-intro">
                        @foreach ($videos as $k => $v)
                            <a class="item-video1 pic-video scale-img text-decoration-none" data-fancybox="video-gallery"
                                href="{{ $helper->getShortVideo($v->link) }}" title="{{ $v->title }}">
                                @if (!empty($v->link))
                                    <img loading="lazy" class="w-100"
                                        src="https://img.youtube.com/vi/{{ $helper->getYoutube($v->link) }}/0.jpg"
                                        alt="{!! $v->title !!}" />
                                @else
                                    <img loading="lazy" class="w-100" src="{{ url('resources/images/noimage.png') }}"
                                        alt="Noimage" />
                                @endif
                            </a>
                        @break
                    @endforeach
                    <div class="div_hiden">
                        <div class="owl-page owl-carousel owl-theme owl-video" data-xsm-items="2:10"
                            data-sm-items="2:10" data-md-items="3:10" data-lg-items="3:10" data-xlg-items="3:10"
                            data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1"
                            data-autoplayspeed="3500" data-dots="0" data-rewind="1" data-autoplay="1"
                            data-smartspeed="300" data-autoplayspeed="500" data-autoplaytimeout="3500"
                            data-nav="0" data-navcontainer=".control-video">
                            @foreach ($videos as $k => $v)
                                <div>
                                    <a class="item-video2 pic-video-2 scale-img text-decoration-none"
                                        data-fancybox="video-gallery" href="{{ $v->link }}"
                                        title="{{ $v->title }}">
                                        @if (!empty($v->link))
                                            <img loading="lazy" class="w-100"
                                                src="https://img.youtube.com/vi/{{ $helper->getYoutube($v->link) }}/0.jpg"
                                                alt="{!! $v->title !!}" />
                                        @else
                                            <img loading="lazy" class="w-100"
                                                src="{{ url('resources/images/noimage.png') }}" alt="Noimage" />
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="control-video control-owl transition"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (count($news) > 0)
    <section class="wrap-newsnb" data-aos="fade-up" data-aos-duration="1000">
        <div class="wrap-content">
            <p class="title-main">
                <span>
                    Tin tức nổi bật
                </span>
            </p>
            <div class="owl-page owl-carousel owl-theme" data-xsm-items="2:10" data-sm-items="2:10"
                data-md-items="3:10" data-lg-items="4:10" data-xlg-items="5:10" data-rewind="1" data-autoplay="1"
                data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500"
                data-autoplayspeed="3500" data-dots="0" data-nav="0"
                data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>"
                data-navcontainer=".control-news">
                @foreach ($news as $k => $v)
                    @php
                        $nameId = $helper->generateNameId($v->title, $v->id);
                    @endphp
                    <div class="item-newsnb">
                        <p class="pic-newsnb">
                            <a class="scale-img" href="{{ route('news', ['slug' => $nameId]) }}"
                                title="{{ $v->title }}">
                                <img loading="lazy" class="w-100"
                                    src="{{ !empty($v->photo1) ? asset('upload/news/' . $v->photo1) : url('resources/images/noimage.png') }}"
                                    alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                            </a>
                        </p>
                        <div class="info-newsnb">
                            <h3 class="mb-0">
                                <a class="name-newsnb text-split text-decoration-none"
                                    href="{{ route('news', ['slug' => $nameId]) }}" title="{{ $v->title }}">
                                    {{ $v->title }}
                                </a>
                            </h3>
                            <p class="time-newshome">
                                Ngày đăng:
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y') }}
                            </p>
                            <div class="desc-newsnb text-split">
                                {!! htmlspecialchars_decode($v->desc) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="control-news control-owl transition"></div>
        </div>
    </section>
@endif
@endsection
