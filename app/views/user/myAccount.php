<h1>My Account</h1>
<p style="color:red;"><?=$error?></p>
<form method="POST" action="/user/changeUser">
    <p><b>Email: </b><?php echo(htmlspecialchars($user->email))?></p>
    <p><label for="email">Email: </label><input type="text" name="email" /></p>
    <p><input type="submit" name="Submit" value="Change Email" /></p>

    <p><b>Name: </b><?php echo(htmlspecialchars($user->firstName . ' ' . $user->lastName))?></p>
    <p><label for="firstName">First name: </label><input type="text" name="firstName" /></p>
    <p><label for="lastName">Last Name: </label><input type="text" name="lastName" /></p>
    <p><input type="submit" name="Submit" value="Change Name" /></p>

    <p><b>Password: </b> **********</p>
    <p><label for="password">Password: </label><input type="password" name="password" /></p>
    <p><label for="confirm">Confirm password: </label><input type="password" name="confirm" /></p>
    <p><input type="submit" name="Submit" value="Change Password" /></p>
    <p><b>Delete Account (Permanent)</b></p>
    <p><input type="submit" name="Submit" value="Delete Account" /></p>
</form>