<style>
#preview, #still{
    transform: scaleX(-1);
}
#still, #canvas, #camera_inactive { 
    display: none;
}

</style>

<div class="post" id="photobooth">
    <video id="preview" class="post_photo"></video>
    <img id="still" class="post_photo" src="#" />    
    <canvas id="canvas"></canvas>

    <div id="camera_active" class="post_icontray">
        <a href="#" title="Snap!"><img id="shutter" class="post_icon" src="/public/resources/icons/photo-camera.svg"/></a>
    </div>

    <div id="camera_inactive" class="post_icontray">
        <a href="#" title="Disapprove"><img id="disapprove" class="post_icon" src="/public/resources/icons/dislike.svg"/></a>
        <a href="#" title="Approve"><img id="approve" class="post_icon" src="/public/resources/icons/like.svg"/></a>
    </div>

</div>

<script src="/public/js/cam.js"></script>
