@extends('x.'.request('view','editor'))

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label> Source : </label>
                    <x-eb class="form-control" name="source" :embed="$command->embed('source')"></x-eb>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> Test : </label>
                    <x-eb class="form-control" name="test" :embed="$command->embed('test')"></x-eb>
                </div>
            </div>
        </div>


    </div>
@endsection
