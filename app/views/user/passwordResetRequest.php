<h1>Reset Password</h1>
<p style="color:red;"><?=$error?></p>
<form method="POST" action="/user/sendResetRequestEmail">
    <p>Enter your email address below to reset your password.</p>
    <p><label for="email">Email: </label><input type="text" name="email" /></p>
    <p><input type="submit" name="Submit" value="Reset Password" /></p>
</form>