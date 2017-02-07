<div  style="width: 350px;
         margin: auto;
         height: 20px;
         margin-top: 200px;">
    <form method="post" action="{{ action('AuthController@auth') }}">
        <input type="text" name="login" placeholder="login" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Войти">
    </form>
</div>

