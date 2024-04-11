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
    <div class="row">
      <div class="col-lg-9 mb-3">
        <div class="title-detail-main">{{$row->title}}</div>
        @if (!empty($row->content))
          <div class="meta-toc">
            <a class="mucluc-dropdown-list_button"></a>
            <div class="box-readmore">
              <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
            </div>
          </div>
          <div class="content-main content-text w-clear content-text" id="toc-content">
            {!! htmlspecialchars_decode($row->content) !!}
          </div>
          <div class="share">
            <b>Chia sẻ:</b>
            <div class="social-plugin w-clear">
              @include('layouts.share')
            </div>
          </div>
        @else
        <div class="alert alert-warning w-100" role="alert">
          <strong>
            Nội dung đang cập nhật
          </strong>
        </div>
        @endif
      </div>
      <div class="col-lg-3">
        @if (count($rowSame) > 0)
          <div class="share othernews mb-3">
            <b>Bài viết liên quan:</b>
            <div class="form-row">
              @foreach ($rowSame as $k => $v)
                @php
                  $nameId = $helper->generateNameId($v->title, $v->id);
                @endphp
                <div class="news-other d-flex flex-wrap col-12 col-lg-12 col-md-6">
                  <a class="scale-img text-decoration-none pic-news-other" href="{{route('news',['slug'=>$nameId])}}" title="{{$v->title}}">
                    <img loading="lazy" class="w-100" src="{{!empty($v->photo1) ? asset('upload/news/'.$v->photo1) : url('resources/images/noimage.png')}}" alt="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" title="{{ !empty($v->photo1) ? $v->title : 'Noimage' }}" />
                  </a>
                  <div class="info-news-other">
                    <h3>
                      <a class="name-news-other text-decoration-none text-split" href="{{route('news',['slug'=>$nameId])}}" title="{{$v->title}}">
                        {{$v->title}}
                      </a>
                    </h3>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @else
        <div class="alert alert-warning w-100" role="alert">
          <strong>
            Chưa có bài viết liên quan
          </strong>
        </div>
        @endif
      </div>
    </div>
  </div>
@endsection
