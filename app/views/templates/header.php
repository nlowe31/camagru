<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="/public/style/main.css" />
    <link rel="stylesheet" href="/public/style/post.css" />
</head>

<body>
    <div id="container">
        <div id="header">
            <div id="header_container">
                <a href="/"><img src="/public/resources/camagru-logo.png" id="logo" /></a>
                <?php if(isset($_SESSION['auth'])) { ?>
                <div id="header_icon_tray">
                    <a href="/post/notifications"><img src="/public/resources/icons/photo-camera.svg" title="New Post" class="header_icon" /></a>
                    <a href="/user/myAccount"><img src="/public/resources/icons/avatar.svg" title="My Account" class="header_icon" /></a>
                    <a href="/user/logout"><img src="/public/resources/icons/logout.svg" title="Logout" class="header_icon" /></a>
                </div>
                <?php } else { ?>
                <div id="header_icon_tray">
                    <a href="/user/login"><img src="/public/resources/icons/avatar.svg" title="Login" class="header_icon" /></a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div id="content">