@extends('ui', ['class' => 'sidebar-mini ltr dark-mode sidenav-toggled'])

@push('js')
    @foreach (['plugins/p-scroll/pscroll.js', 'plugins/sidebar/sidebar.js', 'plugins/sidemenu/sidemenu.js', 'plugins/select2/select2.full.min.js', 'plugins/ace/ace.js', 'plugins/summernote/summernote1.js'] as $src)
        <script src="{{ asset("assets/$src") }}"></script>
    @endforeach
@endpush
@section('app')
    <div id="page-main" class="page-main">
        <div class="app-header header sticky">
            @yield('header-sticky')
        </div>
        <div class="sticky">
            <div class="app-sidebar">
                @yield('sidebar')
            </div>


        </div>
        <!--app-content open-->
        <div class="main-content app-content">
            <div class="side-app">
                @yield('main')
            </div>
        </div>
        <!--app-content close-->
    </div>
@endsection
