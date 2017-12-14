<div class="box">
    <div class="box_title"><h2>My Account</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/changeUser">
            <p><b>Username: </b><?php echo(htmlspecialchars($user->username))?></p>
            <p><input type="text" class="text_box" placeholder="New Username" name="username" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Username" /></p>
        </form>
        <form method="POST" action="/user/changeUser">
            <p><b>Email: </b><?php echo(htmlspecialchars($user->email))?></p>
            <p><input type="email" class="text_box" placeholder="New Email" name="email" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Email" /></p>
        </form>
        <form method="POST" action="/user/changeUser">
            <p><b>Name: </b><?php echo(htmlspecialchars($user->firstName . ' ' . $user->lastName))?></p>
            <p><input type="text" class="text_box" placeholder="First Name" name="firstName" />
            <input type="text" class="text_box" placeholder="Last Name" name="lastName" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Name" /></p>
        </form>
        <form method="POST" action="/user/changeUser">
            <p><b>Password: </b> **********</p>
            <p><input type="password" class="text_box" placeholder="New Password" title="Password must contain at least 6 characters" name="password" /></p>
            <p><input type="password" class="text_box" placeholder="Confirm Password" name="confirm" /></p>
            <p><input type="submit" class="button" name="Submit" value="Change Password" /></p>
        </form>
        <form method="POST" action="/user/changeUser">
            <p><b>Email notifications: </b><?php echo (($user->notifications) ? 'Enabled' : 'Disabled') ?></p>
            <p><input type="submit" class="button" name="Submit" value="Toggle Notifications" /></p>
        </form>
        <form method="POST" action="/user/changeUser">
            <p><b>Delete Account (Permanent)</b></p>
            <p><input type="submit" class="button" name="Submit" value="Delete Account" /></p>
        </form>
    </div>
</div>