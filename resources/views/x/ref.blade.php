@extends('ui', [
    'class' => 'dark-mode',
    'attribute' => $attribute ?? 'x-data={}',
])

@push('js')
    @foreach (['plugins/select2/select2.full.min.js', 'plugins/ace/ace.js', 'plugins/summernote/summernote1.js'] as $src)
        <script src="{{ asset("assets/$src") }}"></script>
    @endforeach
@endpush
@push('script')
    <script>
        function save() {
            var data = {
                'action': '{!! $editor->action !!}',
                'method': 'PUT',
                'inputs': _inputs('#page-main')
            };
            _submit(data).done(function(data) {

                notif({
                    type: 'success',
                    msg: 'Updated'
                });
                if (parent.reload) {
                    parent.reload();
                }
               
            }).fail(function(res) {
                console.log(res);
            });
        }
    </script>
@endpush

@section('app')
    <div id="page-main" class="page-main">
        <div class="main-content">
            @yield('main')
        </div>
    </div>
@endsection
