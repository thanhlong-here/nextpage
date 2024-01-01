@extends('x.' . request('view', 'editor'))

@section('main')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5">

                <div class="card ">
                    <div class="card-body">



                        <div class="form-group">
                            <label>Title :</label>
                            <input name="title" :value="'{{ $app->title }}'" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Description :
                            </label>
                            <textarea name="description" class="form-control" rows="8">{{ $app->description }}</textarea>

                        </div>


                    </div>
                </div>

            </div>


            <div class="col-md-7">


                <div class="row">
                    <div class="col-md-6">

                        <button @click="editor('{!! $editor->newscreen !!}')" class="btn btn-primary"> <i
                                class="fe fe-airplay me-2"></i> New
                            Screen</button>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" name="search" placeholder="Filter by keyword" />
                    </div>
                </div>
                <div x-data='getscreens()' @refscreens.window='init()' class="page-content">

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
                            <template x-for="item in screens">
                                <tr :class="item.id == screen_id ? 'bg-primary' : ''">

                                    <td @click="editor(item.edit)">
                                        <label x-text="item.code">

                                        </label>

                                    </td>
                                    <td @click="editor(item.edit)">
                                        <span x-text="item.updated_at"></span>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <template x-if="item.id != screen_id">
                                                <button @click="_destroy(item.delete)" class="btn btn-danger btn-sm me-2"><i
                                                        class="fe fe-trash"></i></button>

                                            </template>


                                        </div>

                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <input id="screen_index" name="index_flow_id" type="hidden" />

                </div>
            </div>

        </div>

    </div>
@endsection

@push('script')
    <script>
        function reload() {
            dispatchEvent(new CustomEvent("refscreens"));
        }
        $('.select2').select2();



        function openApp() {
            _browser('{{ route('x.app.show', $app) }}', {
                'class': 'modal-fullscreen',
                'title': '<i class="fe fe-airplay me-2"></i>App # {{ $app->code }}',
                'style': '',
            });
        }

        function editor(url) {
            _browser(url, {
                'class': 'modal-fullscreen',
                'title': '<i class="fe fe-airplay me-2"></i>App - screen # {{ $app->code }}',
                'style': '',
            });
        }

        function getscreens() {
            return {
                screens: [],
                screen_id: {{ $app->main_screen->id }},
                async init() {
                    this.screens = await _wjson('{!! $editor->fetch_screens !!}');
                }

            };
        }
    </script>
@endpush
