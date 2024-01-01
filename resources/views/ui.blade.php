@php
    $csss = ['plugins/bootstrap/css/bootstrap.min.css', 'css/style.css', 'css/custom.css', 'css/dark-style.css', 'css/transparent-style.css', 'css/skin-modes.css', 'css/icons.css', 'colors/color1.css'];
    $jss = ['js/jquery.min.js', 'js/jquery-ui.min.js', 'plugins/bootstrap/js/popper.min.js', 'plugins/bootstrap/js/bootstrap.min.js', 'js/alpine.js', 'js/sticky.js', 'js/custom.js', 'plugins/p-scroll/perfect-scrollbar.js', 'plugins/sweet-alert/sweetalert.min.js', 'plugins/notify/js/notifIt.js'];
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('page-meta')
    <title>{{ $title ?? config('app.name', 'Open') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    @foreach ($csss as $src)
        <link href="{{ asset("assets/$src") }}" rel="stylesheet" />
    @endforeach
    @stack('style')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


</head>

<body {!! $attribute ?? '' !!} class="app {{ $class ?? 'dark-mode' }}">
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <div class="spinner">

        </div>
    </div>
    @yield('app')

    @stack('outer')
    <div id="browser" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content w-100 h-100">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="'Browser'"></h5>

                    <button id="browser_exit" type="button" data-bs-dismiss="modal" class="btn-close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <iframe id="browser_content" class="w-100 h-100"></iframe>
            </div>
        </div>
    </div>
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    @foreach ($jss as $src)
        <script src="{{ asset("assets/$src") }}"></script>
    @endforeach
    @stack('js')
    <script>
        const contentbrowser = document.getElementById("browser_content").contentWindow;
        loaded();
    </script>
    @stack('script')
</body>

</html>
