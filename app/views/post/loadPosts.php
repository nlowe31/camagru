<?php

require_once('showPosts.php');

?>
<script src="/public/js/includes.js"></script>
<script>
    var last = <?php echo((array_pop($posts))->pid); ?>;
    console.log("lastid: " + last);
</script>
