<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ $app_name }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <script type="text/javascript" src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}">"></script>
    </head>
    <body>
        <div id="title">
            {{ $app_name }}
        </div>
        <div id="menu-container">
            <ul id="menu">
                <li>
                	<a href="{{ route('main') }}"
                		@if (Route::current()->getName() == 'main') class="active"@endif>Strona główna</a>
            	</li>
                <li>
                	<a href="{{ route('list') }}">Lista elementów zasobu PET</a>
            	</li>
            	<li>
                	<a href="{{ route('add') }}">Dodaj element do zasobu PET</a>
            	</li>
            </ul>
        </div>
        <div id="content">
            @yield('content')
        </div>
    </body>
</html>
