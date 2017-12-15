<div class="post" data-pid="<?= htmlspecialchars($post->pid) ?>">
    <img class="post_photo" src="<?= htmlspecialchars($post->src) ?>">
    <div class="post_top" data-pid="<?= htmlspecialchars($post->pid) ?>">
        <?php
            require('showTop.php');
        ?>
    </div>
    <div class="post_bottom">
    <div class="post_comments" data-pid="<?= htmlspecialchars($post->pid) ?>">
            <?php
                require('showComments.php');
            ?>
        </div>
        <? if (isset($_SESSION['auth'])) { ?>
            <div class="post_new_comment">
                <input class="post_new_comment_text" onkeydown="onEnter(postComment, event);" data-pid="<?= htmlspecialchars($post->pid) ?>" type="text" placeholder="Post a comment"/>
                <a href="#" class="post_new_comment_submit" onclick="postComment(event);" data-pid="<?= htmlspecialchars($post->pid) ?>"><img class="post_icon post_new_comment_icon" title="Submit" src="/public/resources/icons/paper-plane.png"/></a>
            </div>
        <? } ?>
    </div>
</div>