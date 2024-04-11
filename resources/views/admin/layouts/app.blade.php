<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body
    style="background: url('{{ url('resources/images/lgin-admin.svg') }}');min-height: 263px; display:flex;   flex-direction: column; height: 100vh;justify-content:center;">
    @include('admin.layouts.header_auth')
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript">
        /* Toggle eye admin */
        if ($(".eye-toggle-admin")) {
            $(".eye-toggle-admin").click(function() {
                if ($(this).prev().attr("type") === "text") {
                    $(this).prev().attr("type", "password");
                } else {
                    $(this).prev().attr("type", "text");
                }
            });
        }
    </script>
</body>

</html>
