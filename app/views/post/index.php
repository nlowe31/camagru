<div id="feed">
<?php
require_once('loadPosts.php');
?>
</div>

<button id="more">Load More</button>

<script src="/public/js/includes.js"></script>
<script>
//    var last = <?php //echo((array_pop($posts))->pid); ?>//;

    (function () {
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