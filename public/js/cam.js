(function () {

    var streaming = false,
        video = document.querySelector('#preview'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#still'),
        shutter = document.querySelector('#shutter'),
        width = document.querySelector('#photobooth').offsetwidth || document.querySelector('#photobooth').clientWidth,
        height = 0,
        pid = undefined,
        filter = undefined;

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

    var filters = ['banana', 'icecream', 'geek', 'stopsign', 'usa'];

    function toggleFilter(e) {
        var id = e.target.id,
            filterName = id.split('_')[1];
        if (filters.indexOf(filterName) !== -1) {
            if (filter === undefined) {
                shutter.addEventListener('click', function (e) {
                    takePicture();
                    e.preventDefault();
                }, false);
            }
            filter = filterName;
            document.getElementById(id).class = 'post_icon_selected';
        }
        console.log(filter);
    }

    filters.forEach(function (element){
        document.querySelector('#filter_' + element).addEventListener('click', toggleFilter, false);
    });

    function takePicture() {
        console.log("Filter name: " + filter);
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log('OK');
                if (request.responseText !== 'ERROR') {
                    pid = request.responseText;
                    console.log(pid + "\n");
                    showPhoto();
                }
            }
        };
        request.open("POST", "/post/save", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("filter=" + filter + "&image=" + data);
    }

    function showPhoto() {
        photo.src = '#';
        if (pid === undefined) {
            return ;
        }
        console.log("showPhoto(" + pid + ")\n");
        photo.src = '/userData/' + pid + '.png';
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

    document.querySelector('#approve').addEventListener('click', function (e) {
        decide(e);
        e.preventDefault();
    }, false);

    document.querySelector('#disapprove').addEventListener('click', function (e) {
        decide(e);
        e.preventDefault();
    }, false);

    function decide(e) {
        var id = e.target.id,
            request = new XMLHttpRequest();

        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log('OK');
                backToCamera();
            }
        };
        request.open("POST", "/post/decide", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send("pid=" + pid + "&decision=" + id);
    }
})();