<div id="{{ $id }}" x-data="{{ $id }}()" {{ $attributes }}>
    <table class="table datatable">
        <thead>
            <tr>

                <th>
                    <span x-text="'Type'"></span>
                </th>
                <th>
                    <span x-text="'Code'"></span>
                </th>

                <th style="width:.8rem">

                </th>
            </tr>

        </thead>
        <tbody>


            <template x-for="(row,index) in data" :key="index">
                <tr>
                    <td @click=edit(row)>

                        <span x-text="row.type"></span>

                    </td>
                    <td @click=edit(row)>
                        <span x-text="row.code"></span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-icon btn-light pull-right" @click="remove(row)"><i
                                class="fe fe-trash"></i></button>

                    </td>
                </tr>

            </template>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <button type="button" class="btn btn-light btn-block" @click="create()"><i
                            class="fe fe-plus me"></i>
                        New field
                    </button>
                </td>
            </tr>

            @foreach ([
        'code' => 'unique',
        'user_id' => 'user',

        'created_at' => 'datetime',
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ] as $code => $type)
                <tr>

                    <td> {{ $type }}</td>
                    <td> {{ $code }} </td>

                    <td></td>
                </tr>
            @endforeach


        </tfoot>
    </table>
    <div id="{{ $id }}form" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fe fe-edit"></i> Field edit
                    </h5>

                    <button type="button" data-bs-dismiss="modal" class="btn-close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Type</label>
                        <select class="form-control" x-model="field.type" :value="field.type" name="field_type">

                            @foreach ($types as $opt => $input)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" x-model="field.code" :value="field.code"
                            class="form-control input-code" name="field_code" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button @click="save()" class="btn btn-primary"> <i class="fe fe-save"></i> Save </button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        function {{ $id }}() {

            var input_code = $('#{{ $id }}new .input-code');
            var editform = $('#{{ $id }}form');
            var fetch = '{{ $fetch }}';
            return {
                data: {},
                field: {},
                form: {},
                async init() {
                    this.data = _wjson(fetch);
                },
                create() {
                    this.form = {
                        'action': '{{ $store }}',
                        'method': 'POST',
                    }

                    this.field = {
                        'type': 'string',
                        'code': ''
                    };
                    editform.modal('show');
                },
                edit(row) {
                    this.form = {
                        'action': '{{ $update }}',
                        'method': 'PUT',
                    }
                    this.field = row;
                    editform.modal('show');
                },
                save() {
                    this.form.inputs = _inputs('#{{ $id }}form');
                    that = this;
                    _submit(this.form).done(function(data) {

                        if (that.form.method = 'POST') {
                            that.field = {
                                'type': 'string',
                                'code': ''
                            };
                        }
                        input_code.focus();
                        that.init();

                        notif({
                            type: 'success',
                            msg: 'Saved'
                        });
                    }).fail(function(res) {
                        console.log(res);
                    });
                },
                remove(row) {
                    _destroy(row.delete);
                    this.init();

                    notif({
                        type: 'success',
                        msg: 'Deleted'
                    });
                }
            }
        }
    </script>
@endpush
