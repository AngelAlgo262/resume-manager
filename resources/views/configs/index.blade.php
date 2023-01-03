<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Config</title>

    @routes

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    {{-- Card --}}
    <div class="card">
        {{-- Card header --}}
        <div class="card-header d-flex justify-content-center col-md-12">
            <h3>Configuration Panel</h3>
        </div>
        {{-- Card Body --}}
        <div class="card-body">
            <form method="POST" action="#">
                @csrf
                <label>Execute Migrations</label>
                <input class="btn btn-primary ml-1" type="submit" value="OK">
            </form>
            <form class="mt-2">
                <label>Get Themes</label>
                <input class="btn btn-primary ml-5" type="submit" value="OK">
            </form>
        </div>

    </div>


</body>

</html>
