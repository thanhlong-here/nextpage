<div x-data="{{ $id }}()" id="{{ $id }}" {{ $attributes }}>
    <div class="ff_fileupload_wrap">
        <div style="text-align: center" class="ff_fileupload_dropzone_wrap">
            <label class="ff_fileupload_dropzone" for="{{ $id }}upload">
                <template x-if="data.show">
                    <div class="preview">
                        <img class="h-100 me-2" :src="data.show" />
                        <button class="btn btn-danger" @click="remove()"><i class="fe fe-trash"></i></button>
                    </div>
                </template>

                <input id="{{ $id }}upload" @change="change()" style="display: none" type="file"
                    accept=".jpg, .png, image/jpeg, image/png">
            </label>
        </div>
    </div>
</div>

@push('script')
    <script>
        function {{ $id }}() {
            upload = $('#{{ $id }}upload');
            action = '{{ $update }}';
            return {
                'data': {'show':''},
                async init() {
                    this.data = await _wjson('{{ $edit }}');
                },
                change() {
                    var fd = new FormData();
                    fd.append("file", upload[0].files[0]);
                    fd.append('_method', 'PUT');
                    that = this;
                    _apost(action, fd).done(function(data) {
                        notif({
                            type: 'success',
                            msg: 'Uploaded'
                        });
                        that.init();
                    }).fail(function(res) {
                        console.log(res);
                    });
                },
                remove() {
                    var fd = new FormData();
                    fd.append('_method', 'PUT');
                    that = this;
                    _apost(action + '?act=reset', fd).done(function(data) {
                        notif({
                            type: 'success',
                            msg: 'Uploaded'
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
