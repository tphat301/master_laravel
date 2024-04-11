<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @section('head')
    @show

  @include('layouts.css')
</head>
<body>
    @section('seo')
    @show

    @include('layouts.header')
    @include('layouts.menu')
    @include('layouts.mmenu')

    @section('breadcrumbs')
    @show

    @section('slideshow')
    @show
    <div class="wp-website">
      @yield('content')
    </div>

    @include('layouts.footer')
    @include('layouts.js')
    @include('layouts.phone')
    @include('layouts.modal')
</body>
</html>
