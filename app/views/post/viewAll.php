<div id="feed">
<?php
require_once('showPosts.php');
?>
</div>

<button id="more">Load More</button>
<script src="/public/js/includes.js"></script>
<script>
    var last = <?php echo(htmlspecialchars((array_pop($posts))->pid)); ?>;
        scrollURL = '<?= $scrollURL ?>';
</script>
<script src="/public/js/post.js"></script>