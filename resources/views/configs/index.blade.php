<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Config('app.name') }}|Configs</title>

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
    <div class="mt-3 col-md-4 mb-3">
        <div class="card text-center">
            {{-- Card header --}}
            <div class="card-header d-flex justify-content-center col-md-12">
                <h3 class="card-title text-capitalize"
                    style="text-overflow: ellipsis; whithe-space: nowrap; overflow: hidden;">
                    Configuration Panel
                </h3>
            </div>
            {{-- Card Body --}}
            <div class="card-body text-justify">
                <form class="mt-2" method="POST" action="{{ route('config.create') }}">
                    @csrf
                    <label>Execute Migrations</label>
                    <input hidden type="text" name="action" value="action1">
                    <input class="float-right btn btn-primary" type="submit" value="OK">
                </form>
                <form class="mt-2" method="POST" action="{{ route('config.create') }}">
                    @csrf
                    <label>Get Themes</label>
                    <input hidden type="text" name="action" value="action2">
                    <input class="float-right btn btn-primary" type="submit" value="OK">
                </form>
                <form class="mt-2" method="POST" action="{{ route('config.create') }}">
                    @csrf
                    <label>Return to APP</label>
                    <input hidden type="text" name="action" value="action3">
                    <input class="float-right btn btn-primary" type="submit" value="OK">
                </form>
            </div>

        </div>
    </div>
</body>

</html>
