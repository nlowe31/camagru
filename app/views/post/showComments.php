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