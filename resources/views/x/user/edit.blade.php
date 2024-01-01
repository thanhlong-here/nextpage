@section('app')
    <div id="edit" class="container-fluid mt-8">
        <div class="fixed-top p-2 border-bottom pb-0 bg-light">
            <div class="pull-right">

                <button class="btn btn-primary" @click="save()" id="btnsave"> <i class="fe fe-save"></i>
                    <span x-text="'Save'"></span>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label x-text="'Name'" for="name"></label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="">
                </div>

                <div class="form-group">
                    <label x-text="'Email'" for="email"></label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                        placeholder="email">
                </div>

                @if ($user->is_root)
                    <span class="baged-pill"> Full access</span>
                @else
                    <div class="form-group ">

                        <label x-text="'Roles'" for="roles"></label>
                        <select name="roles" multiple class="select2 form-control">
                            @foreach ($roles as $id => $opt)
                                <option {{ $user->roles->where('id', $id)->count() ? 'selected' : '' }}
                                    value="{{ $id }}">
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $('.select2').select2();
        conf = {
            'action': '{{ route('x.user.update', $user) }}',
            'method': 'PUT'
        }


        function payload() {
            conf.inputs = _inputs('#edit');
            return conf;
        }

        function save() {
            var data = payload();
            _submit(data).done(function(data) {
                notif({
                    type: 'success',
                    msg: 'Updated'
                });
                if (parent.reload) {
                    parent.reload();
                }

            }).fail(function(res) {
                console.log(res);
            });
        }
    </script>
@endpush

@extends('ui', [
    'class' => 'dark-mode',
    'attribute' => 'x-data={}',
])
