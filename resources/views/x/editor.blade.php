@extends('x.sidebar', ['attribute' => "x-data='{}'"])

@section('sidebar')
    <div class="main-sidemenu">
        <ul class="side-menu">

            <li>
                <div class="side-menu__item">
                    <input placeholder="Search" class="form-control" />
                </div>

            </li>
            @if (isset($editor->detect))
                <li class="slide is-expanded">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-git-branch"></i><span class="side-menu__label"> Related</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul x-data='getdetect()' @redetect.window='init()' class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Recents</a></li>

                        <template x-for="(url,key) in refs">
                            <li>
                                <a href="#" @click='openRef(url,key)' class="slide-item"><span
                                        x-text="key"></span></a>
                            </li>
                        </template>

                    </ul>
                </li>

                @push('script')
                    <script>
                        function redetect() {
                            dispatchEvent(new CustomEvent("redetect"));
                            console.log('re-detect');
                        }

                        function getdetect() {
                            return {
                                refs: [],
                                async init() {
                                    this.refs = await _wjson('{!! $editor->detect !!}');
                                    console.log(this.refs);
                                },
                                openRef(url, key) {
                                    _browser(url, {
                                        'class': 'modal-fullscreen',
                                        'title': '<i class="fe fe-git-branch me-2"></i>' + key,
                                        'style': '',
                                    });
                                }
                            };
                        }
                    </script>
                @endpush
            @endif
            <li>
                <a href="{{ $editor->create }}" class="side-menu__item">
                    <i class="side-menu__icon fe fe-plus me-2"></i>
                    <span class="side-menu__label">New </span>
                </a>
            </li>
            <li class="slide is-expanded">
                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-clock"></i><span class="side-menu__label">Recents</span><i
                        class="angle fe fe-chevron-right"></i></a>
                <ul x-data='getmenu()' @remenu.window='init()' class="slide-menu">
                    <li class="side-menu-label1"><a href="javascript:void(0)">Recents</a></li>

                    <template x-for="item in menu">
                        <li><a :href="item.edit" class="slide-item"><span x-text="item.code"></span></a></li>
                    </template>

                </ul>
            </li>
        </ul>


    </div>
@endsection

@section('header-sticky')
    <div class="container-fluid main-container">
        <div class="d-flex">

            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <div class="d-flex">
                <div class="input-group">

                    <span class="input-group-text bg-light"> Code :</span>
                    <input name="code" value="{{ $editor->code }}" class="form-control autosave" />
                </div>
            </div>
            <div class="d-flex order-lg-2 ms-auto header-right-icons">

                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">




                            @if (isset($editor->show))
                                <div class="dropdown d-flex">
                                    <button class="btn btn-sm btn-info me-2" @click="outPut()"> <i class="fe fe-globe"></i>
                                        Output
                                    </button>
                                    @push('script')
                                        <script>
                                            function outPut() {
                                                _browser('{!! $editor->show !!}', {
                                                    'class': 'modal-fullscreen',
                                                    'title': '<i class="fe fe-globe me-2"></i> Output',
                                                    'style': '',
                                                });
                                            }
                                        </script>
                                    @endpush
                                </div>
                            @endif
                            <div class="dropdown d-flex">


                                <button class="btn btn-sm btn-primary" @click="save()" id="btnsave"> <i
                                        class="fe fe-save"></i>
                                    Save
                                </button>
                            </div>
                            <!-- FULL-SCREEN -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        function remenu() {
            dispatchEvent(new CustomEvent("remenu"));
           
        }

        function getmenu() {
            return {
                menu: [],
                async init() {
                    this.menu = await _wjson('{!! $editor->fetch !!}');
                }
            };
        }

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

                if (redetect) redetect();
                remenu();
                // if (reload){ 
                //     console.log(reload) 
                // };
              
                
            }).fail(function(res) {
                console.log(res);
            });
        }
    </script>
@endpush
