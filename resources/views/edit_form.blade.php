

@extends('template.template')

@section('content')
    <div style="margin-left: 80px">
        <h4 style="margin-left: 20px;">Форма редактирования объявления <a class="btn btn-xs btn-success" href="{{ action('AuthController@index') }}">На главную</a></h4>

        @if(session()->has('notification'))
            <h5 style="color: green;">{{ session()->get('notification') }}</h5>
            {{ session()->forget('notification') }}
        @endif

        <div class="col-lg-7">

            <form method="post" action="{{ action('AdController@store') }}">
                <input type="hidden" value="{{ $ad['id'] }}" >
                <input type="text" name="title" placeholder="Название" required value="{{ $ad['title'] }}" style=" margin-bottom: 10px">
                <br>
                <textarea name="description" placeholder="Описание" required>{{ $ad['description'] }}</textarea>
                <br>
                <input type="submit" value="Изменить">
            </form>

        </div>
    </div>
@stop