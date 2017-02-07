<div  style="width: 350px;
         margin: auto;
         height: 20px;
         margin-top: 200px;">

    <form method="post" action="{{ action('AuthController@auth') }}">
        <input type="text" name="login" placeholder="login" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Войти">
    </form>
    @if(session()->has('notification'))
        <h5 style="margin-left: 20px; color: green;">{{ session()->get('notification') }}</h5>
        {{ session()->forget('notification') }}
    @endif
</div>

