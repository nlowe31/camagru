<?php
?>

<div id="feed">
<!--    <div class="post">-->
<!--        <img class="post_photo" src="/userData/eiffel.JPG">-->
<!--        <div class="post_bottom">-->
<!--            <div class="post_icon_tray">-->
<!--                <a href="#"><img class="post_icon" title="Like" src="/public/resources/icons/heart.png"/></a>-->
<!--                <a href="#"><img class="post_icon" title="Comment" src="/public/resources/icons/chat-1.png"/></a>-->
<!--                <a href="#"><div class="post_user">username</div></a>-->
<!--            </div>-->
<!--            <div class="post_likes">42 likes</div>-->
<!--            <div class="post_comment">-->
<!--                <div class="post_comment_user">username</div>-->
<!--                <div class="post_comment_text">this is the comment text</div>-->
<!--            </div>-->
<!--            <div class="post_comment">-->
<!--                <div class="post_comment_user">username</div>-->
<!--                <div class="post_comment_text">this is the comment text</div>-->
<!--            </div>-->
<!--            <div class="post_new_comment">-->
<!--                <input class="post_new_comment_text" type="text" value="This is a new comment..." />-->
<!--                <a href="#"><img class="post_icon post_new_comment_icon" title="Submit" src="/public/resources/icons/paper-plane.png"/></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>

<script src="/public/js/includes.js"></script>
<script>
(function () {
    var current = 0,
        posts = [];

    ajax_old("/post/getPosts", ("current=" + current), function () {
        if (this.readyState === 4 && this.status === 200) {
            response = this.responseText;
        }
    })();

    console.log(response);

//    var text = '[{"pid":45,"uid":19,"src":"\/userData\/45.png","created":"2017-10-07 14:26:31","confirmed":1,"likes":0,"comments":0},{"pid":46,"uid":19,"src":"\/userData\/46.png","created":"2017-10-07 14:28:01","confirmed":1,"likes":0,"comments":0},{"pid":49,"uid":19,"src":"\/userData\/49.png","created":"2017-10-07 15:09:11","confirmed":1,"likes":0,"comments":0},{"pid":77,"uid":19,"src":"\/userData\/77.png","created":"2017-10-08 12:45:28","confirmed":1,"likes":0,"comments":0}]';

//    posts = JSON.parse(text);
//    displayPost();

    function displayPost(post_data) {
        console.log('displayPost');
        var post = document.createElement('div'),
            photo = document.createElement('img'),
            post_bottom = document.createElement('div'),
            icon_tray = document.createElement('div'),
            like_button = document.createElement('a'),
            comment_button = document.createElement('a'),
            username = document.createElement('div'),
            likes = document.createElement('div'),
            comments = document.createElement('div');

        post.id = 'post_' + post_data.pid;
        post.className = 'post';

        photo.className = 'post_photo';
        photo.src = post_data.src;
        post.appendChild(photo);

        post_bottom.className = 'post_bottom';
        post.appendChild(post_bottom);

        icon_tray.className = 'post_icon_tray';
        post_bottom.appendChild(icon_tray);

        like_button.innerHTML = '<img class="post_icon" title="Like" src="/public/resources/icons/heart.png"/>';
        comment_button.innerHTML = '<img class="post_icon" title="Comment" src="/public/resources/icons/chat-1.png"/>';

        _('feed').appendChild(post);
    }

//    console.log(posts);
    posts.forEach(function(elem){
        displayPost(elem);
    });
    current += posts.length;
}) ();
</script>
