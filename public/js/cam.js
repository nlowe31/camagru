// (function() {
//     document.getElementById('message').innerHTML = "Script loaded.";
    
//     var preview = document.getElementById('preview'),
//         vendorURL = window.URL || window.webkitURL;

//     navigator.getUserMedia = navigator.getUserMedia || 
//                             navigator.webkitGetUserMedia || 
//                             navigator.mozGetUserMedia || 
//                             navigator.msGetUserMedia;
    
//     // if (navigator.getUserMedia()) {
//         navigator.getUserMedia({
//             video: true,
//             audio: false
//         }, function (stream) {
//             preview.src = vendorURL.createObjectURL(stream);
//             video.play();
//         }, function (error) {
//             console.log("An error occurred with video playback.");
//         });
//     // }
//     // else {
//     //     document.getElementById('message').innerText = "Hey! We need access to your webcam in order to take photos. Click Allow on your browser to get going!";
//     // }
    
// })();

(function () {

    var streaming = false,
        video = document.querySelector('#preview'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#still'),
        shutter = document.querySelector('#shutter'),
        width = document.querySelector('#photobooth').offsetwidth || document.querySelector('#photobooth').clientWidth,
        height = 0;

    navigator.getMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function (stream) {
            // if (navigator.mozGetUserMedia) {
            //     video.mozSrcObject = stream;
            // } else {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
                localstream = stream;
            // }
            video.play();
        },
        function (err) {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function (ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        video.pause();
        video.src = "";
        localstream.getTracks()[0].stop();
        video.style.display = 'none';
        photo.style.display = 'block';
        document.querySelector('#camera_active').style.display = 'none';
        document.querySelector('#camera_inactive').style.display = 'block';
    }

    shutter.addEventListener('click', function (ev) {
        takepicture();
        ev.preventDefault();
    }, false);

    document.querySelector('#approve').addEventListener('click', navigator.getMedia(), false);
    document.querySelector('#disapprove').addEventListener('click', navigator.getMedia(), false);

})();