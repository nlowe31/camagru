<?php
foreach ($post->comments as $comment) {
    ?>
    <div class="post_comment">
        <div class="post_comment_user"><?= htmlspecialchars($comment->username) ?></div>
        <div class="post_comment_text"><?= htmlspecialchars($comment->text) ?></div>
    </div>
    <?php
}
?>