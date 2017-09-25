<h1>Sign Up</h1>
<p style="color:red;"><?=$error?></p>
<form method="POST" action="/user/createUser">
    <label for="email">Email: </label><input type="text" name="email" /><br />
    <label for="firstName">First name: </label><input type="text" name="firstName" /> 
    <label for="lastName">Last Name: </label><input type="text" name="lastName" /><br />
    <label for="password">Password: </label><input type="password" name="password" /><br />
    <label for="confirm">Confirm password: </label><input type="password" name="confirm" /><br />
    <input type="submit" name="Submit" value="Sign Up" />
</form>