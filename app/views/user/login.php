<h1>Login</h1>
<p style="color:red;"><?=$error?></p>
<form method="POST" action="/user/auth">
    <label for="email">Email: </label><input type="text" name="email" /><br />
    <label for="password">Password: </label><input type="password" name="password" /><br />
    <input type="submit" name="Login" value="Login" />
</form>