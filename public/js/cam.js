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

    var filter = document.querySelector('#filter');
    filter.style.width = width + 'px';

    function toggleFilter(e) {
        var id = e.target.id,
            filterName = id.split('_')[1],
            path = '/public/resources/filters/' + filterName + '.png',
            filter = document.querySelector('#filter');
        if (filter.src === path) {
            filter.src = '#';
        }
        else {
            filter.src = path;
        }
    }

    var filters = ['banana', 'icecream', 'geek', 'stopsign', 'usa'];
    filters.forEach(function (element){
        document.querySelector('#filter_' + element).addEventListener('click', toggleFilter, false);
    });

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        video.style.display = 'none';
        photo.style.display = 'block';
        document.querySelector('#camera_active').style.display = 'none';
        document.querySelector('#camera_inactive').style.display = 'block';
    }

    function backToCamera() {
        video.style.display = 'block';
        photo.style.display = 'none';
        document.querySelector('#camera_active').style.display = 'block';
        document.querySelector('#camera_inactive').style.display = 'none';
    }

    shutter.addEventListener('click', function (ev) {
        takepicture();
        ev.preventDefault();
    }, false);


    function savePhoto() {
        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log('OK');
                backToCamera();
            }
                // document.getElementById('still').src = this.responseText;
        }
        request.open("POST", "/post/save", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("image=" + photo.src + "&filter=banana");
    }

    document.querySelector('#approve').addEventListener('click', savePhoto, false);
    document.querySelector('#disapprove').addEventListener('click', backToCamera, false);

})();