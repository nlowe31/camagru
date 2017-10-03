<div class="box login">
    <div class="box_title"><h2>Login</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/auth">
            <p><input type="text" placeholder="Email" name="email" /></p>
            <p><input type="password" placeholder="Password" name="password" /></p>
            <input class="button" type="submit" name="Login" value="Login" />
            <p><a class="link" href="/user/signup"><i>Register</i></a><br/><a class="link" href="/user/passwordResetRequest"><i>Forgot password?</i></a></p>
        </form>
    </div>
</div>