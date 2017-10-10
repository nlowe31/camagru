<link rel="stylesheet" href="/public/style/create.css">

<div id="dashboard">
    <div class="post" id="photobooth">
        <div class="box_title"><h2>Create Post</h2></div>
        <video id="preview" class="post_photo"></video>
        <img id="still" class="post_photo" src="#"/>
        <canvas id="canvas"></canvas>

        <div id="filter_bar" class="post_icontray">
            <img id="filter_banana" class="post_icon filter_icon" src="/public/resources/filters/banana_icon.png"/>
            <img id="filter_icecream" class="post_icon filter_icon" src="/public/resources/filters/icecream_icon.png"/>
            <img id="filter_geek" class="post_icon filter_icon" src="/public/resources/filters/geek_icon.png"/>
            <img id="filter_stopsign" class="post_icon filter_icon" src="/public/resources/filters/stopsign_icon.png"/>
            <img id="filter_usa" class="post_icon filter_icon" src="/public/resources/filters/usa_icon.png"/>
        </div>

        <div id="camera_active" class="post_icontray">
            <img id="shutter" class="post_icon_large" src="/public/resources/icons/photo-camera.png"/>
            <img id="upload_button" class="post_icon_large" src="/public/resources/icons/upload.png"/>
            <input type="file" id="upload" style="display:none;"/>
        </div>

        <div id="camera_inactive" class="post_icontray">
            <img id="disapprove" class="post_icon_large" src="/public/resources/icons/dislike.png"/>
            <img id="approve" class="post_icon_large" src="/public/resources/icons/like.png"/>
        </div>
    </div>
    <div id="sidebar" class="box">
        <div id="mini_posts">
            <?php require_once('showMiniPosts.php'); ?>
        </div>
        <img id="load_more" class="post_icon" src="/public/resources/icons/next-1.png"/>
    </div>
</div>

<script src="/public/js/includes.js"></script>
<script>
    var last = <?php echo((array_pop($posts))->pid); ?>;
</script>
<script src="/public/js/create.js"></script>
