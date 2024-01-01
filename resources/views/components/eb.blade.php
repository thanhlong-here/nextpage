<div x-data="{{ $id }}()" {{ $attributes }}>
    <pre data-bs-toggle="modal" data-bs-target="#{{ $id }}mdsource" class="preview">
        <code x-text='data.source'></code>
    </pre>


    <div id="{{ $id }}mdsource" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fe fe-code"></i> {{ Str::title( $name) ?? '' }}
                    </h5>

                    <div class="pull-right">
                        <button @click="save()" class="btn btn-sm btn-primary actsave">
                            <i class="fe fe-save"></i>
                            Save
                        </button>
                        <button @click="ok()" type="button" data-bs-dismiss="modal" class="btn-close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="vh-100" style="position: relative;" id="{{ $id }}source"></div>
                </div>
            </div>
        </div>
    </div>



</div>

<script>
    function {{ $id }}() {
        var esource = ace.edit("{{ $id }}source");

        esource.setTheme("ace/theme/monokai");
        esource.session.setMode("ace/mode/php");
        return {
            'data': [],
            init() {
                this.load();
            },
            async load() {
                data = await _wjson('{!! $get !!}');
                this.data = data;

                esource.setValue(data.source);

            },
            ok() {
                if (confirm('Dou you want save data?')) {
                    this.save();
                }
            },
            save() {
                fd = new FormData();
                fd.append("source", esource.getValue());
                fd.append('_method', 'PUT');
                this.data.source = esource.getValue();

                _apost('{{ $update }}', fd).done(function(data) {
                    notif({
                        type: 'success',
                        msg: 'Saved'
                    });
                    if(redetect) redetect();
                }).fail(function(res) {
                    console.log(res);
                });

            },
        };
    }
</script>
