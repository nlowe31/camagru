<!DOCTYPE html>
<html>
<head>
<style>
#preview, #still {
    transform: scaleX(-1);
}
</style>
</head>
<body>

<div id="photobooth">
    <video id="preview"></video>
    <canvas id="canvas" style="display:none;"></canvas>
    <button id="shutter">Take Photo</button>
    <img src="http://placekitten.com.s3.amazonaws.com/homepage-samples/408/287.jpg" id="still">
</div>

<script src="/public/js/cam.js"></script>

</body>
</html>