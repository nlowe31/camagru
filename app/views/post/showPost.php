<div class="post" data-pid="<?= $post->pid ?>">
    <img class="post_photo" src="<?= $post->src ?>">
    <div class="post_bottom">
        <div class="post_icon_tray">
            <a href="#"><img class="post_icon" title="Like" data-pid="<?= $post->pid ?>"
                             src="/public/resources/icons/heart.svg"/></a>
            <a href="#"><img class="post_icon" title="Comment" data-pid="<?= $post->pid ?>"
                             src="/public/resources/icons/chat-1.svg"/></a>
            <a href="#">
                <div class="post_user"><?= $post->username ?></div>
            </a>
        </div>
        <div class="post_likes"><?= $post->likeCount ?> likes</div>
        <div class="post_comments" data-pid="<?= $post->pid ?>">
            <?php
                require('showComments.php');
            ?>
        </div>
        <div class="post_new_comment">
            <input class="post_new_comment_text" data-pid="<?= $post->pid ?>" type="text" placeholder="Post a comment"/>
            <a href="#" class="post_new_comment_submit" data-pid="<?= $post->pid ?>" onclick="postComment.apply(this, arguments)"><img class="post_icon post_new_comment_icon" title="Submit"
                             src="/public/resources/icons/paper-plane.svg"/></a>
        </div>
    </div>
</div>
