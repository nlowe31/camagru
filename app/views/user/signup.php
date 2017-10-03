<div class="box login">
    <div class="box_title"><h2>Sign Up</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/createUser">
            <p><input type="text" placeholder="Username" name="username" required/></p>
            <p><input type="email" placeholder="Email" name="email" title="Must be a valid email address" required/></p>
            <p><input type="text" placeholder="First Name" name="firstName" required/></p>
            <p><input type="text" placeholder="Last Name" name="lastName" required/></p>
            <p><input type="password" placeholder="Password" name="password" pattern="/^.{6,}$/" title="Must contain at least 6 characters" required/></p>
            <p><input type="password" placeholder="Confirm Password" name="confirm" required/></p>
            <p><input class="button" type="submit" name="Submit" value="Sign Up" required/></p>
        </form>
    </div>
</div>