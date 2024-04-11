<!-- Basehref -->
<base href="{{url('/')}}"/>
<!-- UTF-8 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Title, Keywords, Description -->
<title>
  @if ($seo->get('title'))
    {{$seo->get('title')}}
  @else
    @yield('title')
  @endif
</title>
<meta name="keywords" content="{{$seo->get('keywords')}}"/>
<meta name="description" content="{!! $seo->get('description') !!}"/>
<meta name="robots" content="index,follow" />

<!-- Favicon -->
@if (!empty($favicon->photo))
  <link href="{{asset('upload/photo/'.$favicon->photo)}}" rel="shortcut icon" type="image/x-icon" />
@else
  <link href="" rel="shortcut icon" type="image/x-icon" />
@endif

<!-- Webmaster Tool -->
{!! !empty($setting->mastertool) ? $setting->mastertool : '' !!}

<!-- GEO -->
<meta name="geo.region" content="VN" />
<meta name="geo.placename" content="Hồ Chí Minh" />
<meta name="geo.position" content="10.823099;106.629664" />
<meta name="ICBM" content="10.823099, 106.629664" />

<!-- Author - Copyright -->
<meta name='revisit-after' content='1 days' />
<meta name="author" content="{{!empty($setting->title) ? $setting->title : ''}}" />
<meta name="copyright" content="{{!empty($setting->title) ? $setting->title : ''}} - [{{!empty($setting->address) ? $setting->address : ''}}]" />

<!-- Facebook -->
<meta property="og:type" content="{{$seo->get('type')}}" />
<meta property="og:site_name" content="{{!empty($setting->title) ? $setting->title : ''}}" />
<meta property="og:title" content="{{$seo->get('title')}}" />
<meta property="og:description" content="{{$seo->get('description')}}" />
<meta property="og:url" content="{{$seo->get('url')}}" />
<meta property="og:image" content="{{$seo->get('photo')}}" />
<meta property="og:image:alt" content="{{$seo->get('title')}}" />
<meta property="og:image:type" content="{{$seo->get('photo:type')}}" />
<meta property="og:image:width" content="{{$seo->get('photo:width')}}" />
<meta property="og:image:height" content="{{$seo->get('photo:height')}}" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{!empty($setting->email) ? $setting->email : ''}}" />
<meta name="twitter:creator" content="{{!empty($setting->title) ? $setting->title : ''}} " />
<meta property="og:url" content="{{ $seo->get('url') }}" />
<meta property="og:title" content="{{$seo->get('title')}}" />
<meta property="og:description" content="{{$seo->get('description')}}" />
<meta property="og:image" content="{{$seo->get('photo')}}" />

<!-- Canonical -->
<link rel="canonical" href="{{$seo->get('url')}}" />

<!-- No change color IOS -->
<meta name="format-detection" content="telephone=no">

<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php /*<meta name="viewport" content="width=1349">*/ ?>
