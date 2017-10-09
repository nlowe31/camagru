<div class="post" data-pid="<?= $post->pid ?>">
    <img class="post_photo" src="<?= $post->src ?>">
    <div class="post_top" data-pid="<?= $post->pid ?>">
        <?php
            require('showTop.php');
        ?>
    </div>
    <div class="post_bottom">
    <div class="post_comments" data-pid="<?= $post->pid ?>">
            <?php
                require('showComments.php');
            ?>
        </div>
        <div class="post_new_comment">
            <input class="post_new_comment_text" data-pid="<?= $post->pid ?>" type="text" placeholder="Post a comment"/>
            <a href="#" class="post_new_comment_submit" onclick="postComment(event);" data-pid="<?= $post->pid ?>"><img class="post_icon post_new_comment_icon" title="Submit" src="/public/resources/icons/paper-plane.png"/></a>
        </div>
    </div>
</div>