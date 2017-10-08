<div id="feed">
<?php
require_once('showPosts.php');
showPosts($posts);
?>
</div>

<button id="more">Load More</button>

<script src="/public/js/includes.js"></script>
<script>
    (function () {
        var last = <?php echo((array_pop($posts))->pid); ?>;

        _('more').addEventListener("click", scroll);

        function scroll() {
            ajax("/post/scroll", ("last=" + last), function () {
                if (this.readyState === 4 && this.status === 200) {
                    _('feed').insertAdjacentHTML('beforeend', this.responseText);
                }
            });
        }
    }) ();
</script>