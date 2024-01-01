@extends('x.'.request('view','editor'))

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <x-schema :value="$schema" class="form-control"></x-schema>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">

                        <button type="button" @click=editor('{!! $editor->create_mix !!}') class="btn btn-primary">
                            <i class="fe fe-server"></i>
                            New mix
                        </button>
                    </div>
                    <div class="col-md-6">

                        <input class="form-control" name="search" placeholder="Filter by keyword" />
                    </div>
                </div>

                <div x-data="getMix()" @reload.window="init()" class="page-content">
                    <table class="table datatable">
                        <thead>
                            <tr>

                                <th>
                                    Code
                                </th>
                                <th>
                                    Last Updated
                                </th>

                                <th style="width:.8rem">

                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            <template x-for="(row,index) in data" :key="index">
                                <tr>
                                    <td @click=editor(row.edit)>

                                        <span x-text="row.code"></span>

                                    </td>
                                    <td @click=editor(row.edit)>
                                        <span x-text="row.updated_at"></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-danger pull-right"
                                            @click=_destroy(row.delete)><i class="fe fe-trash"></i></button>

                                    </td>
                                </tr>

                            </template>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
@push('script')
    <script>
        function reload() {
            dispatchEvent(new CustomEvent("reload"));
        }
       function editor(url) {
            _browser(url, {
                'class': 'modal-fullscreen',
                'title': '<i class="fe fe-server me-2"></i> Mix editor',
                'style': '',
            });
        }

        function getMix() {
            return {
                'data': {},
                async init() {
                    this.data = await _wjson('{!! $mix_fetch !!}');
                }
            }
        }
    </script>
@endpush
