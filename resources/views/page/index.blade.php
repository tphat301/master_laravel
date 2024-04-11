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
  @if (!empty($row))
    <div class="wrap-content padding-top-bottom">
      <div class="title-main">
        <span>
          {{$row->title}}
        </span>
      </div>
      <div class="content-main w-clear">
        {!! htmlspecialchars_decode($row->content) !!}
      </div>
      <div class="share">
        <b>Chia sẻ:</b>
        <div class="social-plugin w-clear">
          @include('layouts.share')
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-warning w-100" role="alert">
        <strong>
          Đang cập nhật dữ liệu
        </strong>
    </div>
  @endif
@endsection
