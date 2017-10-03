<div class="box">
    <div class="box_title"><h2>My Account</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/changeUser">
            <p><b>Username: </b><?php echo(htmlspecialchars($user->username))?></p>
            <p><b>Email: </b><?php echo(htmlspecialchars($user->email))?></p>
            <p><input type="email" placeholder="New Email" name="email" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Email" /></p>

            <p><b>Name: </b><?php echo(htmlspecialchars($user->firstName . ' ' . $user->lastName))?></p>
            <p><input type="text" placeholder="First Name" name="firstName" />
            <input type="text" placeholder="Last Name" name="lastName" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Name" /></p>

            <p><b>Password: </b> **********</p>
            <p><input type="password" placeholder="New Password" title="Password must contain at least 6 characters" name="password" /></p>
            <p><input type="password" placeholder="Confirm Password" name="confirm" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Password" /></p>
            <p><b>Delete Account (Permanent)</b></p>
            <p><input type="submit" class="button" name="Submit" value="Delete Account" /></p>
        </form>
    </div>
</div>