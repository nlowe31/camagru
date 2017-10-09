<style>
    #preview {
        transform: scaleX(-1);
    }

    #still, #canvas, #camera_inactive {
        display: none;
    }

    #dashboard {
        margin: auto;
        text-align: center;
        display: block;
        /*position: absolute;*/
    }

    #photobooth, #sidebar {
        vertical-align: top;
        margin: 4em 2em auto;
        height: 40em;
    }

    #sidebar {
        /*float: right;*/
        position: relative;
        display: inline-block;
        width: 10em;
        overflow: auto;
    }

    #photobooth {
        /*float: left;*/
        display: inline-block;
        width: 35em;
    }

    #shutter, #upload {
        opacity: 0.2;
    }

</style>

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
            <img id="upload" class="post_icon_large" src="/public/resources/icons/upload.png"/>
        </div>

        <div id="camera_inactive" class="post_icontray">
            <img id="disapprove" class="post_icon_large" src="/public/resources/icons/dislike.png"/>
            <img id="approve" class="post_icon_large" src="/public/resources/icons/like.png"/>
        </div>
    </div>
    <div id="sidebar" class="box">
        <div class="mini_post">
            <img class="mini_post_photo" src="/userData/104.png"/>
            <div class="mini_post_overlay" data-pid="">
                <img class="mini_post_overlay_icon" src="/public/resources/icons/garbage.png">
            </div>
        </div>
    </div>
</div>

<script src="/public/js/includes.js"></script>
<script src="/public/js/cam.js"></script>
