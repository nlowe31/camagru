<div class="box login">
    <div class="box_title"><h2>Sign Up</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/createUser">
            <p><input type="text" class="text_box" placeholder="Username" name="username" required maxlength="254" /></p>
            <p><input type="email" class="text_box" placeholder="Email" name="email" title="Must be a valid email address" required/></p>
            <p><input type="text" class="text_box" placeholder="First Name" name="firstName" required maxlength="254" /></p>
            <p><input type="text" class="text_box" placeholder="Last Name" name="lastName" required maxlength="254" /></p>
            <p><input type="password" class="text_box" placeholder="Password" name="password" title="Must contain at least 6 characters" required/></p>
            <p><input type="password" class="text_box" placeholder="Confirm Password" name="confirm" required/></p>
            <p><input class="button" type="submit" name="Submit" value="Sign Up" required/></p>
        </form>
    </div>
</div>