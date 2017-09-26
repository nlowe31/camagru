<h1>Password Reset</h1>
<p style="color:red;"><?=$error?></p>
<form method="POST" action="/user/newPassword">
    <p><b>Email: </b><?php echo(htmlspecialchars($user->email))?></p>

    <p><label for="password">New Password: </label><input type="password" name="password" /></p>
    <p><label for="confirm">Confirm password: </label><input type="password" name="confirm" /></p>
    <p><input type="submit" name="Submit" value="Change Password" /></p>
</form>