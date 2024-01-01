@php
    $js = ['plugins/fileuploads/js/fileupload.js', 'plugins/fileuploads/js/file-upload.js', 'plugins/p-scroll/pscroll.js','plugins/select2/select2.full.min.js', 'plugins/ace/ace.js', 'plugins/summernote/summernote1.js'];
@endphp
@push('js')
    @foreach ($js as $src)
        <script src="{{ asset("assets/$src") }}"></script>
    @endforeach
@endpush
@section('app')
    <div id="edit" class="container-fluid mt-8">
        <div class="fixed-top p-2 border-bottom pb-0 bg-light">
            <div class="pull-right">

                <label class="m-2 ">
                    <i class="fe fe-clock me-2"></i> {{ $editor->updated_at ?? now() }}
                </label>
                <button class="btn btn-primary" @click="save()" id="btnsave"> <i class="fe fe-save"></i>
                    <span x-text="'Save'"></span>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="code"> Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $editor->code }}">
                </div>


                <div class="form-group ">

                    <label for="description"> Description</label>
                    <textarea rows="5" x-text="'{{ $editor->description }}'" name="description" class="form-control"></textarea>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        conf = {
            'action': '{{ $editor->action }}',
            'method': '{{ $editor->method ?? 'PUT' }}'
        }


        function payload() {
            conf.inputs = _inputs('#edit');
            return conf;
        }

        function save() {
            var data = payload();
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
@extends('ui', [
    'class' => 'dark-mode',
    'attribute' => 'x-data={}',
])
