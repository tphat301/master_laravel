@section('head')
    @parent
    @include('layouts.head')
@endsection

@section('seo')
    @parent
    @include('layouts.seo')
@endsection

@extends('welcome')
@section('title', !empty($row->title) ? $row->title : $titleMain)

@section('breadcrumbs')
    @parent
    @include('layouts.breadcrumb')
@endsection

@section('content')
    <div class="wrap-content padding-top-bottom">
        @if (!empty($row))
            <form action="{{ route('order.add', ['id' => $row->id]) }}" method="GET">
                @csrf
                <div class="grid-pro-detail d-flex flex-wrap justify-content-between align-items-start">
                    <div class="left-pro-detail">
                        <a id="Zoom-1" class="MagicZoom"
                            data-options="zoomMode: off; hint: off; rightClick: true; selectorTrigger: hover; expandCaption: false; history: false;"
                            href="{{ !empty($row->photo1) ? asset('upload/product/' . $row->photo1) : url('resources/images/noimage.png') }}"
                            title="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}">
                            <img loading="lazy" class="w-100"
                                src="{{ !empty($row->photo1) ? asset('upload/product/' . $row->photo1) : url('resources/images/noimage.png') }}"
                                alt="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}" />
                        </a>
                        @if (count($rowGallery) > 0)
                            <div class="gallery-thumb-pro">
                                <div class="owl-page owl-carousel owl-theme owl-pro-detail" data-xsm-items="3:10"
                                    data-sm-items="4:10" data-md-items="5:10" data-lg-items="5:10" data-xlg-items="5:10"
                                    data-rewind="1" data-autoplay="0" data-loop="0" data-lazyload="0" data-nav="1"
                                    data-navtext="<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-left' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='15 6 9 12 15 18' /></svg>|<svg xmlns='https://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-chevron-right' width='44' height='45' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><polyline points='9 6 15 12 9 18' /></svg>"
                                    data-navcontainer=".control-pro-detail">
                                    <div>
                                        <a class="thumb-pro-detail" data-zoom-id="Zoom-1"
                                            href="{{ !empty($row->photo1) ? asset('upload/product/' . $row->photo1) : url('resources/images/noimage.png') }}"
                                            title="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}">
                                            <img loading="lazy" class="w-100"
                                                src="{{ !empty($row->photo1) ? asset('upload/product/' . $row->photo1) : url('resources/images/noimage.png') }}"
                                                alt="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}" />
                                        </a>
                                    </div>
                                    @foreach ($rowGallery as $v)
                                        <div>
                                            <a class="thumb-pro-detail" data-zoom-id="Zoom-1"
                                                href="{{ !empty($v->photo) ? asset('upload/gallery/' . $v->photo) : url('resources/images/noimage.png') }}"
                                                title="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}">
                                                <img loading="lazy" class="w-100"
                                                    src="{{ !empty($v->photo) ? asset('upload/gallery/' . $v->photo) : url('resources/images/noimage.png') }}"
                                                    alt="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}"
                                                    title="{{ !empty($row->photo1) ? $row->title : 'Noimage' }}" />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="control-pro-detail control-owl transition"></div>
                            </div>
                        @endif
                    </div>
                    <div class="right-pro-detail">
                        <p class="title-pro-detail mb-2">
                            {{ $row->title }}
                        </p>
                        <div class="social-plugin social-plugin-pro-detail w-clear">
                            @include('layouts.share')
                        </div>
                        <ul class="attr-pro-detail">
                            @if (!empty($row->code))
                                <li>
                                    <label class="attr-label-pro-detail">
                                        Mã sản phẩm:
                                    </label>
                                    <div class="attr-content-pro-detail">
                                        {{ $row->code }}
                                    </div>
                                </li>
                            @endif
                            <li>
                                <label class="attr-label-pro-detail">Giá:</label>
                                <div class="attr-content-pro-detail">
                                    @if ($row->sale_price)
                                        <span
                                            class="price-new-pro-detail">{{ number_format($row->sale_price, 0, ',', '.') . 'đ' }}</span>
                                        <span
                                            class="price-old-pro-detail">{{ number_format($row->regular_price, 0, ',', '.') . 'đ' }}</span>
                                    @else
                                        <span
                                            class="price-new-pro-detail">{{ !empty($row->regular_price) ? number_format($row->regular_price, 0, ',', '.') . 'đ' : 'Liên hệ' }}</span>
                                    @endif
                                </div>
                            </li>
                        </ul>
                        @if ($row->sale_price)
                            <li class="d-flex flex-wrap align-items-center mt-3 mb-3">
                                <label class="attr-label-pro-detail d-block me-2 mb-0">Số lượng:</label>
                                <div
                                    class="attr-content-pro-detail d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="quantity-pro-detail">
                                        <input type="number" name="quantity" class="qty-pro" min="1"
                                            value="1" />
                                    </div>
                                </div>
                            </li>
                            <div class="cart-pro-detail d-flex flex-wrap align-items-center justify-content-between">
                                <button type="submit"
                                    class="transition buynow addcart text-decoration-none d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-basket2-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1" />
                                    </svg>
                                    <span>Mua ngay</span>
                                </button>
                            </div>
                        @endif
                        <div class="desc-pro-detail content-text">
                            {!! htmlspecialchars_decode($row->desc) !!}
                        </div>
                    </div>
                </div>
                <div class="tabs-pro-detail">
                    <ul class="nav nav-tabs" id="tabsProDetail" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-pro-detail-tab"data-toggle="tab"
                                data-target="#info-pro-detail" role="tab" aria-selected="true">
                                Thông tin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="commentfb-pro-detail-tab"data-toggle="tab"
                                data-target="#commentfb-pro-detail" role="tab">
                                Bình luận
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4 pb-4" id="tabsProDetailContent">
                        <div class="tab-pane fade show active" id="info-pro-detail" role="tabpanel">
                            <div class="content-text">
                                {!! htmlspecialchars_decode($row->content) !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="commentfb-pro-detail" role="tabpanel">
                            <div class="fb-comments" data-href="{{ $seo->get('url') }}" data-numposts="3"
                                data-colorscheme="light" data-width="100%"></div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="alert alert-warning w-100" role="alert">
                <strong>
                    Không tìm thấy kết quả
                </strong>
            </div>
        @endif
    </div>
    <div class="wrap-content">
        <p class="title-main">
            <span>
                Sản phẩm liên quan
            </span>
        </p>
        @if (count($rowSame) > 0)
            <div class="prdhot-list">
                @foreach ($rowSame as $v)
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
                        <p class="prdhot-cart">
                            <span class="btn-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                                </svg>
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="pagg">
                {!! $rowSame->links() !!}
            </div>
        @else
            <div class="alert alert-warning w-100" role="alert">
                <strong>
                    Không tìm thấy kết quả
                </strong>
            </div>
        @endif
    </div>
@endsection
