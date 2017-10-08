<?php

require_once('showPosts.php');

?>
<script src="/public/js/includes.js"></script>
<script>
    var last = <?php echo((array_pop($posts))->pid); ?>;
    console.log(last);

    function postComment(e) {
        e.preventDefault();
        var pid = e.target.dataset.pid,
            text;
        console.log(pid);
        if (pid === undefined) {
            return ;
        }
        text = $('input[data-pid="' + pid + '"]').value;
        console.log(e.target.getAttribute('pid'));
//        console.log(pid);
//        console.log(text);

//        ajax("/post/postComment", "pid=" + pid + "&text=" +

    }
</script>
