@extends('x.'.request('view','editor'))


@section('main')
    <div class="container">
        <div class="form-group">
            <label>Value : </label>
            @switch($simple->type)
                @case('media')
                    <x-media :value="$simple->value"></x-media>
                @break

                @case('content')
                    <x-content :value="$simple->value"></x-content>
                @break

                @default
                    <input name="value" value="{{$simple->value}}" class="form-control" />
            @endswitch
        </div>


    </div>
@endsection

