(function() {
    document.getElementById('message').innerHTML = "Script loaded.";
    
    var preview = document.getElementById('preview'),
        vendorURL = window.URL || window.webkitURL;

    navigator.getUserMedia = navigator.getUserMedia || 
                            navigator.webkitGetUserMedia || 
                            navigator.mozGetUserMedia || 
                            navigator.msGetUserMedia;
    
    if (navigator.getUserMedia()) {
        navigator.getUserMedia({
            video: true,
            audio: false
        }, function (stream) {
            preview.src = vendorURL.createObjectURL(stream);
            video.play();
        }, function (error) {
            console.log("An error occurred with video playback.");
        });
    }
    else {
        document.getElementById('message').innerText = "Hey! We need access to your webcam in order to take photos. Click Allow on your browser to get going!";
    }
    
})();