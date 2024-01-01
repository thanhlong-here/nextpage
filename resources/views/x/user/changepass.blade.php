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
                    <label x-text="'New password'"></label>
                    <input type="password" name="password" class="form-control" required placeholder="password">
                </div>

                <div class="form-group">
                    <label for="password-confirm" required x-text="'{{ __('Confirm password') }}'"></label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        autocomplete="new-password">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        conf = {
            'action': '{{ route('x.user.update', [$user, 'action' => 'changepass']) }}',
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
