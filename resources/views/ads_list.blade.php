@extends('template.template')

@section('content')
    <div style="margin-left: 80px">
        <a class="btn btn-success" href="{{ action('AdController@create') }}">Добавить новое</a>
    <h4 style="margin-left: 20px;">Все объявления </h4>

    @if(session()->has('notification'))
        <h5 style="margin-left: 20px;" style="color: green;">{{ session()->get('notification') }}</h5>
        {{ session()->forget('notification') }}
    @endif

    <div class="col-lg-7">

        @foreach($ads as $ad)
            <div style="
                margin: 5px;
                padding: 5px;
                border: 1px solid blue;
                float: inherit;
                width: 100%;
            ">
                <div style="width: 85%; float: left">
                    <h4><a href="{{ action('AdController@show', ['id' => $ad['id']]) }}">{{ $ad['title'] }}</a></h4>
                    <p>{{ $ad['description'] }}</p>

                    <p>Автор объявления: <b>{{ $ad['user']['login'] }}</b></p>
                    <p>Опубликовано: <i>{{ $ad['created_at'] }}</i></p>
                </div>
                @if($auth_user['id'] == $ad['user_id'])
                <div style="width: 14%; float: right; font-size: 14px; padding-top: 15px;">
                    <a class="btn  btn-success" href="{{ action('AdController@edit', ['id' => $ad['id']] ) }}">Изменить</a>
                    <br>
                    <br>
                    <a class="btn btn-warning" href="{{ action('AdController@destroy', ['id' => $ad['id']] ) }}">Удалить</a>
                </div>
                @endif
            </div>
        @endforeach



                {{  $ads->render() }}

    </div>
</div>
@stop
