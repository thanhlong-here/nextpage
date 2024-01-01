@extends('x.page', [
    'attribute' => "x-data='getdata()' @reload.window='init()'",
])
@php
    $title = Str::title($name);
@endphp

@section('main')
    <!-- CONTAINER -->
    <div class="main-container container-fluid ">
        <div class="page-header">
            <div class="page-title"> <span class="me-2"> <i class=" {{ $icon }} me-2'"></i> {{ $title }}
                </span>
                <button type="button" @click=editor('{{ $create ?? '#' }}') class="btn btn-sm btn-primary">
                    <i class="fe fe-plus me-2"></i>New
                </button>
            </div>
            <div>
                <input id="filterword" class="form-control" name="filterword" placeholder="Input Keyword" />
            </div>
        </div>
        <div class="content">
            <div class="row">
                <template x-for="item in data">

                    <div class="col-xl-4 col-md-4 col-sm-6">
                        @yield('card',view('x.inc.card') )
                        
                    </div>

                </template>
            </div>
        </div>

    </div>
    <!-- CONTAINER END -->
@endsection

@push('script')
    <script>
        function reload() {
            dispatchEvent(new CustomEvent("reload"));
        }

        function getdata() {
            return {
                data: [],
                async init() {
                    this.data = await _wjson('{!! $fetch !!}');
                },
                editor(url) {
                    _browser(url, {
                        'class': '{{ $classmodal ?? 'modal-fullscreen' }}',
                        'title': '<i class=" {{ $icon }} me-2"></i> {{ $title }} editor',
                        'style': '',
                    });
                }
            }
        }
    </script>
@endpush

