@extends('template.template')

@section('content')
    <div style="margin-left: 80px">
        <h4 style="margin-left: 20px;">Форма добавления нового объявления</h4>

        @if(session()->has('notification'))
            <h5 style="color: green;">{{ session()->get('notification') }}</h5>
            {{ session()->forget('notification') }}
        @endif

        <div class="col-lg-7">

            <form method="post" action="{{ action('AdController@store') }}">
                <input type="text" name="title" placeholder="Название" style=" margin-bottom: 10px" required>
                <br>
                <textarea name="description" placeholder="Описание" required></textarea>
                <br>
                <input type="submit" value="Создать">
            </form>

        </div>
    </div>
@stop


