<div class="box">
    <div class="box_title"><h2>Forgot Password</h2></div>
    <div class="box_content">
        <p class="error"><?=$error?></p>
        <form method="POST" action="/user/sendResetRequestEmail">
            <p>Enter your email address below to reset your password.</p>
            <p><input type="text" placeholder="Email" class="text_box" name="email" /></p>
            <p><input type="submit" class="button" name="Submit" value="Reset Password" /></p>
        </form>
    </div>
</div>