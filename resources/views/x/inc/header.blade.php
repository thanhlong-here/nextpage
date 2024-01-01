<div class="container-fluid main-container">
    <div class="d-flex">

        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
        <div class="d-flex">
            <button data-bs-toggle="modal" data-bs-target="#modalsearch" class="btn btn-light">
                <i class="fe fe-search me-2"></i> <span> Search</span>
            </button>
        </div>
        <div class="d-flex order-lg-2 ms-auto header-right-icons">
            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
            </button>
            <div class="navbar navbar-collapse responsive-navbar p-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2">


                        <div class="d-flex">

                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                            </a>
                        </div>
                        <!-- Theme-Layout -->

                        <div class="dropdown d-flex">
                            <a class="nav-link icon full-screen-link nav-link-bg">
                                <i class="fe fe-minimize fullscreen-button"></i>
                            </a>
                        </div>

                        <div class="dropdown d-flex">
                            <a class="nav-link icon nav-link-bg actlogout">
                                <i class="fe fe-power text-danger"></i>
                            </a>
                        </div>
                        <!-- FULL-SCREEN -->
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@push('outer')
    <div id="modalsearch" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">

        <div x-data="search_all()" @research.window='init()' class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="p-2">
                    <div class="input-group">

                        <input id="search_allpage" name="search_input" class="form-control">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">


                </div>
            </div>
        </div>
    </div>
@endpush
@push('script')
    <script>
        $('.actlogout').click(function() {
            if (confirm('Do you want logout?')) {
                _submit({
                    'method': 'POST',
                    'action': '{{ route('x.logout') }}'
                }).done(function(data) {
                    window.location.reload();
                }).fail(function(res) {
                    console.log(res);
                });
            }
        });
        $('#modalsearch').on('shown.bs.modal', function() {
            $('#search_allpage').focus();
        });

        function search_all() {
            return {
                data: [],
                async init() {

                }
            }
        }
    </script>
@endpush
