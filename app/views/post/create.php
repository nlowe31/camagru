<style>
#preview, #still{
    transform: scaleX(-1);
}
#still, #canvas, #camera_inactive {
    display: none;
}

#filter {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
}

#dashboard {
    margin: auto;
    text-align: center;
}

#photobooth_container {
    position: relative;
    display: inline-block;
    width: 35em;
}

#sidebar_container {
    position: relative;
    display: inline-block;
    max-width: 20em;
}

#photobooth, #sidebar {
    display: block;
}

</style>

<div id="dashboard">
    <div id="photobooth_container">
        <div class="post" id="photobooth">
            <video id="preview" class="post_photo"></video>
            <img id="still" class="post_photo" src="#" />
            <img id="filter" class="post_photo" src="#" />
            <canvas id="canvas"></canvas>

            <div id="filter_bar" class="post_icontray">
                <a href="#" title="Banana!"><img id="filter_banana" class="post_icon" src="/public/resources/filters/banana.png"/></a>
                <a href="#" title="Banana!"><img id="filter_icecream" class="post_icon" src="/public/resources/filters/icecream.png"/></a>
                <a href="#" title="Banana!"><img id="filter_geek" class="post_icon" src="/public/resources/filters/geek.png"/></a>
                <a href="#" title="Banana!"><img id="filter_stopsign" class="post_icon" src="/public/resources/filters/stopsign.png"/></a>
                <a href="#" title="Banana!"><img id="filter_usa" class="post_icon" src="/public/resources/filters/usa.png"/></a>
            </div>

            <div id="camera_active" class="post_icontray">
                <a href="#" title="Snap!"><img id="shutter" class="post_icon_large" src="/public/resources/icons/photo-camera.svg"/></a>
            </div>

            <div id="camera_inactive" class="post_icontray">
                <a href="#" title="Disapprove"><img id="disapprove" class="post_icon_large" src="/public/resources/icons/dislike.svg"/></a>
                <a href="#" title="Approve"><img id="approve" class="post_icon_large" src="/public/resources/icons/like.svg"/></a>
            </div>
        </div>
    </div>
    <div id="sidebar_container">
        <div id="sidebar" class="box">

        </div>
    </div>
</div>

<script src="/public/js/includes.js"></script>
<script src="/public/js/cam.js"></script>
