@extends('x.'.request('view','editor'))


@section('main')
    <div class="container-fluid">
        <div class="offset-md-1 col-md-10">
            @foreach ($fields as $field)
                <div class="form-group">
                    <label>
                        {{ Str::title($field->code) }}
                    </label>
                    @switch($field->type)
                        @case('media')
                            <x-media :value="$mix->val($field->code)"></x-media>
                        @break

                        @case('content')
                            <x-content :value="$mix->val($field->code)"></x-content>
                        @break

                        @default
                            <input name="{{ $field->code }}" value="{{$mix->val($field->code)}}" class="form-control" />
                    @endswitch
                </div>
            @endforeach
        </div>

    </div>
@endsection

