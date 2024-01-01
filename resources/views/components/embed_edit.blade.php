@if ($debug)
    <div class="tab-menu-heading tab-menu-heading-boxed">
        <div class="tabs-menu1">
            <ul class="nav panel-tabs">


                <li>
                    <a href="#{{ $id }}tab_dev" class="active" data-bs-toggle="tab" class="text-dark">
                        Develop
                    </a>
                </li>
                <li>
                    <a href="#{{ $id }}tab_test" data-bs-toggle="tab" class="text-dark">
                        Test
                    </a>
                </li>
                <li>
                    <a href="#{{ $id }}tab_debug" @click="detect()" data-bs-toggle="tab"
                        class="btn btn-sm btn-light">
                        <i class="fe fe-play"></i>
                        Debug
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endif
<div class="tabs-menu-body">
    <div class="tab-content">
        <div class="tab-pane active" id="{{ $id }}tab_dev">
            <div class="vh-100" style="position: relative;" id="{{ $id }}_dev"></div>
        </div>
        <div class="tab-pane" id="{{ $id }}tab_test">
            <div class="vh-100" style="position: relative;" id="{{ $id }}_test"></div>
        </div>

        <div class="tab-pane" id="{{ $id }}tab_debug">
            <div class="container-fluid" id="{{ $id }}_debug">
                <div class="row">

                    <div class="col-md-3">

                        <template x-for="(value,key) in refs" :key="key">
                            <div @click=refEditor(key,value) class="form-group">

                                <div class="form-control">
                                    <span x-text="key"></span>
                                    <i class="pull-right fe fe-arrow-right"></i>
                                </div>
                            </div>
                        </template>

                    </div>
                    <div class="col-md-9">
                        <iframe class="form-control ps-scollbar w-100 vh-100"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@push('script')
    <script>
        function {{ $id }}refesh() {
            var output = $("#{{ $id }}tab_debug iframe");
            const ps = new PerfectScrollbar(output);
            output.attr('src', '{{ $show }}');
        }

        function {{ $id }}() {
            var dev = ace.edit("{{ $id }}_dev");
            var test = ace.edit("{{ $id }}_test");
            var preview = $("#{{ $id }} code");
            var actsave = $("#{{ $id }}edit .actsave");
            var actclose = $("#{{ $id }}edit .btn-close");

            var detect = '{{ $detect }}';
            var edit = '{{ $edit }}';

            dev.setTheme("ace/theme/monokai");
            dev.session.setMode("ace/mode/php");
            test.setTheme("ace/theme/monokai");
            test.session.setMode("ace/mode/php");

            return {
                'refs': [],
                async init() {
                    var data = await _wjson(edit);
                    preview.text(data.develop);
                    dev.setValue(data.develop);
                    test.setValue(data.test);
                },
                async detect() {
                    this.save();

                    this.refs = await _wjson(detect);
                    {{ $id }}refesh();
                },
                firm() {
                    if (confirm('Dou you want save data?')) {
                        this.save();
                    }
                },
                save() {
                    preview.text(dev.getValue());

                    fd = new FormData();
                    fd.append("develop", dev.getValue());
                    fd.append("test", test.getValue());
                    fd.append('_method', 'PUT');
                    _apost('{{ $update }}', fd).done(function(data) {

                        notif({
                            type: 'success',
                            msg: 'Saved'
                        });

                    }).fail(function(res) {
                        console.log(res);
                    });
                },
                refEditor(key, value) {
                    console.log(value);
                    _browser(value + '?ref={{ $id }}', {
                        'class': 'modal-fullscreen',
                        'title': '<i class="fe fe-codepen me-2"></i>' + key,
                        'style': '',
                    });
                }
            };
        }
    </script>
@endpush
