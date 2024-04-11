@section('head')
  @parent
  @include('layouts.head')
@endsection

@section('seo')
  @parent
  @include('layouts.seo')
@endsection

@extends('welcome')

@section('title', $titleMain)

@section('breadcrumbs')
  @parent
  @include('layouts.breadcrumb')
@endsection

@section('content')
  <div class="prd-page">
    <div class="wrap-content padding-top-bottom">
      <p class="title-main">
        <span>
          {{$titleMain}}
        </span>
      </p>
      @if (count($rows) > 0)
        <div class="row-news row">
          @foreach ($rows as $v)
            @php
              $nameId = $helper->generateNameId($v->title, $v->id);
            @endphp
            <div class="news d-flex flex-wrap col-md-6 pb-3" data-aos="fade-up" data-aos-duration="1000">
              <a href="{{route('news',['slug'=>$nameId])}}" class="pic-news scale-img text-decoration-none" title="{!!$v->title!!}">
                <img loading="lazy" class="w-100" src="{{!empty($v->photo1) ? asset('upload/news/'.$v->photo1) : url('resources/images/noimage.png')}}" alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}"/>
              </a>
              <div class="info-news">
                <h3>
                  <a href="{{route('news',['slug'=>$nameId])}}" class="name-page-news text-decoration-none text-split" title="{!!$v->title!!}">
                    {!! $v->title !!}
                  </a>
                </h3>
                <div class="desc-page-news text-split mb-0">
                  {!! htmlspecialchars_decode($v->desc) !!}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="alert alert-warning w-100" role="alert">
          <strong>
            Không tìm thấy kết quả
          </strong>
        </div>
      @endif
    </div>
  </div>
@endsection
