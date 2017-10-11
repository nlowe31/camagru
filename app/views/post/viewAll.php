<div id="feed">
<?php
require_once('showPosts.php');
?>
</div>

<div id="post_end"><p>That's it!<br>No more posts to show.<br><a href="/post/create">Create a new post</a></p></div>

<script src="/public/js/includes.js"></script>
<script>
<?php
    echo 'scrollURL = "' . $scrollURL . '";';
?>
</script>
<script src="/public/js/post.js"></script>