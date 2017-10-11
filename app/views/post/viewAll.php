<div id="feed">
<?php
require_once('showPosts.php');
?>
</div>

<button id="more">Load More</button>
<script src="/public/js/includes.js"></script>
<script>
<?php
    if (empty($posts)) {
        echo 'var last = 0;';
    }
    else {
        echo 'var last = ' . htmlspecialchars((array_pop($posts))->pid) . ';';
    }
    echo 'scrollURL = ' . $scrollURL ';';
?>
</script>
<script src="/public/js/post.js"></script>