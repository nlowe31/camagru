    var streaming = false,
        video = _('preview'),
        canvas = _('canvas'),
        photo = _('still'),
        shutter = _('shutter'),
        upload_button = _('upload_button'),
        upload = _('upload'),
        width = _('photobooth').offsetwidth || _('photobooth').clientWidth,
        height = 0,
        pid = undefined,
        filter = undefined,
        webcam = true;

    navigator.getMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    if (navigator.getMedia) {
        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function (stream) {
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
                localstream = stream;
                video.play();
            },
            function (err) {
                webcam = false;
                console.log("Webcam not available.");
            }
        );
    }

    video.addEventListener('canplay', function (ev) { 
        ev.preventDefault();
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
        var id = e.currentTarget.id,
            filterName = id.split('_')[1];
        if (filters.indexOf(filterName) !== -1) {
            if (filter === undefined) {
                if (webcam === true) {
                    shutter.style.opacity = 1;
                    shutter.addEventListener('click', function (e) {
                        takePhoto();
                        e.preventDefault();
                    }, false);
                }
                upload_button.style.opacity = 1;                
                upload_button.addEventListener('click', function (e) {
                    _('upload').click();
                    e.preventDefault();
                }, false);
                upload.addEventListener('change', function (e) {
                    uploadPhoto();
                    e.preventDefault();
                }, false);
            }
            else {_('filter_' + filter).className = 'post_icon filter_icon';}
            _(id).className = 'post_icon_selected filter_icon';
            filter = filterName;
        }
    }

    function takePhoto() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');

        ajax("/post/take", ("filter=" + filter + "&image=" + data), function (response) {
            pid = response;
            showPhoto();
        });
    }

    function uploadPhoto() {
        _('upload_button').src = "/public/resources/icons/reload.png";

        var file = _('upload').files[0],
            formData = new FormData();

        formData.append('image', file, file.name);
        formData.append('filter', filter);

        var request = new XMLHttpRequest();
        request.open('post', '/post/upload', true);
        request.onload = function () {
            _('upload_button').src = "/public/resources/icons/upload.png";
            if (this.responseText !== 'ERROR' && Boolean(this.responseText)) {
                pid = this.responseText;
                showPhoto();
            }
            else {
                alert("Unable to save photo. Images must of type .jpg or .png and must be less than 2 MB in size.");
            }
        };
        request.send(formData);
    }

    function showPhoto() {
        photo.src = '#';
        if (pid === undefined) {
            return ;
        }
        photo.src = '/userData/' + pid + '.png';
        video.style.display = 'none';
        photo.style.display = 'block';
        _('camera_active').style.display = 'none';
        _('camera_inactive').style.display = 'block';
    }

    function backToCamera() {
        video.style.display = 'block';
        photo.style.display = 'none';
        _('camera_active').style.display = 'block';
        _('camera_inactive').style.display = 'none';
    }

    function decide(e) {
        var id = e.currentTarget.id;

        ajax("/post/decide", ("pid=" + pid + "&decision=" + id), function (response) {
            if (response === 'APPROVE') {
                addMiniPost(pid);
            }
            backToCamera();
        });
    }

    function addMiniPost(pid) {
        ajax("/post/loadMini", ("pid=" + pid), function (response) {
            _('mini_posts').insertAdjacentHTML('afterbegin', response);
        });
    }

    function loadMoreMiniPosts() {
        var lastPost = _('mini_posts').lastElementChild,
            lastID;
        if (Boolean(lastPost)) {
            lastID = lastPost.dataset.pid;
            ajax("/post/scrollMini", ("last=" + lastID), function (response) {
                _('mini_posts').insertAdjacentHTML('beforeend', response);
            });
        }
    }

    function deletePost(e) {
        pid = e.currentTarget.dataset.pid;
        if (pid === undefined){
            return ;
        }
        ajax("/post/delete", ("pid=" + pid), function () {
            toRemove = $('[class="mini_post"][data-pid="' + pid + '"]');
            _('mini_posts').removeChild(toRemove);
        });
    }

    addEventListenerToClass('filter_icon', 'click', toggleFilter);
