<div id="{{ $id }}">
    <div class="card" style="min-height: 80px;max-height: 280px" data-bs-toggle="modal"
        data-bs-target="#{{ $id }}edit">
        <div class="card-body preview"></div>
    </div>
</div>

@push('outer')
    <div id="{{ $id }}edit" x-data="{{ $id }}()" class="modal fade" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mt-0 modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fe fe-edit"></i> Content editor
                    </h5>
                    <div class="pull-right">

                        <button type="button" @click="save()" class="btn btn-sm btn-primary">
                            <i class="fe fe-save"></i> <span>Save</span>
                        </button>

                        <button type="button" @click=" if (confirm('Dou you want save data?')){ save()}"
                            data-bs-dismiss="modal" class="btn-close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <textarea class="summernote"></textarea>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function {{ $id }}() {
            var editor = $('#{{ $id }}edit .summernote');
            var preview = $('#{{ $id }} .preview');
            var action = "{{ $update }}";
            editor.summernote({
                height: $(window).height(),
                callbacks: {
                    onImageUpload: function(files, editor, welEditable) {
                        _summernoteUpload(files, $(this), "{{ route('x.content.addmedia', $value) }}")
                    }
                }
            });

            return {
                data: {
                    'html': ''
                },
                async init() {
                    data = await _wjson('{{ $edit }}');

                    preview.html(data.html);
                    editor.summernote('code', data.html);

                    this.data = data;
                },
                save() {
                    var fd = new FormData();
                    fd.append('_method', 'PUT');
                    fd.append("html", editor.val());
                    that = this;
                    _apost(action, fd).done(function(data) {
                        notif({
                            type: 'success',
                            msg: 'Saved'
                        });
                        that.init();
                    }).fail(function(res) {
                        console.log(res);
                    });
                }
            }
        }
    </script>
@endpush
