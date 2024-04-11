<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ url('resources/images/favi-admin.png') }}" rel="shortcut icon" type="image/x-icon" />
    <title>
        @yield('title')
    </title>
    @include('admin.layouts.css')
</head>

<body>
    <div class="wrapper">
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')
        <div class="content-wrapper" style="min-height: 596px;">
            @yield('content')
        </div>
        @include('admin.layouts.footer')
    </div>
    @include('admin.layouts.js')
</body>

</html>
