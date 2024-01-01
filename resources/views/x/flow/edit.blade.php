@extends('x.'.request('view','editor'))

@section('main')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-body">
                        <div class="form-group">
                            <label x-text="'URI :'"></label>
                            <input name="uri" :value="'{{ $flow->uri }}'" class="form-control autosave"
                                placeholder="://" />
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Pemission:
                                </label>
                                <div class="pull-right">
                                    <input id="is_public" type="hidden" value="{{ $flow->is_public }}" name="is_public" />
                                    <label id="publish" for="is_public" class="float-end btn btn-sm">


                                    </label>

                                </div>


                            </div>
                            <div id="roles" style="display: {{ $flow->is_public ? 'none' : 'show' }}">
                                <select name="roles" multiple class="select2 form-control  ">

                                    @foreach ($roles as $id => $opt)
                                        <option {{ $flow->roles->where('id', $id)->count() ? 'selected' : '' }}
                                            value="{{ $id }}">
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>


                        <div class="form-group">
                            <label>Test :</label>
                            <x-eb class="form-control" name="env test" :embed="$flow->embed('test')"></x-eb>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-7">


                <div class="form-group">
                    <label>Kernel :</label>
                    <x-eb class="form-control" name="kernel" :embed="$flow->embed('kernel')"></x-eb>
                </div>

                <div class="form-group">
                    <label>Method GET :</label>
                    <x-eb class="form-control" name="method get" :embed="$flow->embed('get')"></x-eb>
                </div>

                <div class="form-group">
                    <label>Method POST :</label>
                    <x-eb class="form-control" name="method post" :embed="$flow->embed('post')"></x-eb>
                </div>
             
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script>
        var ip = $("#is_public");

        function status() {

            if (ip.val() == 1) {

                $('#publish').text('Set Private');
                $('#publish').removeClass('btn-dark');
                $('#publish').addClass('btn-info');

            } else {
                $('#publish').text('Set publish');
                $('#publish').removeClass('btn-info');
                $('#publish').addClass('btn-dark');
            }
        }
        status();
        $('#publish').click(function() {
            if (ip.val() == 1) ip.val(0);
            else ip.val(1);
            status();
            $('#roles').toggle();
        })
        $('.select2').select2();
    </script>
@endpush
