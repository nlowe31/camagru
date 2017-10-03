<div class="box">
    <div class="box_title"><h2>Sign Up</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/createUser">
            <p><label for="username">Username </label><input type="text" name="username" /></p>
            <p><label for="email">Email </label><input type="text" name="email" /></p>
            <p><label for="firstName">First name </label><input type="text" name="firstName" /></p>
            <p><label for="lastName">Last Name </label><input type="text" name="lastName" /></p>
            <p><label for="password">Password </label><input type="password" name="password" /></p>
            <p><label for="confirm">Confirm password </label><input type="password" name="confirm" /></p>
            <p><input class="button" type="submit" name="Submit" value="Sign Up" /></p>
        </form>
    </div>
</div>