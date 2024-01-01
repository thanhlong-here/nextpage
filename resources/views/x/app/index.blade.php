@section('card')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> <span x-text="item.code"></span>
            </h4>
            <div class="card-options">


                <button @click="_destroy(item.delete)" type="button" class="btn btn-danger btn-sm me-2">
                    <i class="fe fe-trash"></i>

                </button>
                <button class="btn btn-info btn-sm" @click="editor(item.edit)"><i class="fe fe-edit"></i></button>

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
                    Title :
                </label>
                <span x-text="item.title"> </span>
            </p>
        </div>
    </div>
@endsection

@extends('x.index')
