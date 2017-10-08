<?php
function showPosts($posts) {
    foreach ($posts as $post) {
        ?>
        <div class="post" pid="<?= $post->pid ?>">
            <img class="post_photo" src="<?= $post->src ?>">
            <div class="post_bottom">
                <div class="post_icon_tray">
                    <a href="#"><img class="post_icon" title="Like" pid="<?= $post->pid ?>"
                                     src="/public/resources/icons/heart.svg"/></a>
                    <a href="#"><img class="post_icon" title="Comment" pid="<?= $post->pid ?>"
                                     src="/public/resources/icons/chat-1.svg"/></a>
                    <a href="#">
                        <div class="post_user"><?= $post->username ?></div>
                    </a>
                </div>
                <div class="post_likes"><?= $post->likeCount ?> likes</div>
                <?php
                foreach ($post->comments as $comment) {
                    ?>
                    <div class="post_comment">
                        <div class="post_comment_user"><?= $comment->username ?></div>
                        <div class="post_comment_text"><?= $comment->text ?></div>
                    </div>
                    <?php
                }
                ?>
                <div class="post_new_comment">
                    <input class="post_new_comment_text" type="text" value="This is a new comment..."/>
                    <a href="#"><img class="post_icon post_new_comment_icon" title="Submit"
                                     src="/public/resources/icons/paper-plane.svg"/></a>
                </div>
            </div>
        </div>
        <?php
    }
}
?>