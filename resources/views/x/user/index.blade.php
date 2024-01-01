@extends('x.index')
@section('card')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> <span x-text="item.name"></span>
            </h4>
            <div class="card-options">

                <template x-if=!item.is_root>
                    <button @click="_destroy(item.delete)" type="button" class="btn btn-danger btn-sm me-2">
                        <i class="fe fe-trash"></i>
                    </button>
                </template>


                <button class="btn btn-info btn-sm me-2" @click="editor(item.edit)"><i class="fe fe-edit"></i></button>

                <button class="btn btn-warning btn-sm" @click="editor(item.pass)"><i class="fe fe-lock"></i></button>
            </div>
        </div>
        <div class="card-body">

            <p>
                <label>
                    <i class="fe fe-clock me-1"></i> <span class="" x-text="item.updated_at"></span>
                </label>
            </p>
            <p>
                <label>
                    <span class="" x-text="item.email"></span>
                </label>
            </p>
        </div>
    </div>
@endsection
