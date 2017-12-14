<?php
if (isset($_SESSION['auth']) && $post->isLiked($_SESSION['auth'])) {
    $like_src = '/public/resources/icons/heart_active.png';
}
else
    $like_src = '/public/resources/icons/heart.png';
?>

<div class="post_icon_tray">
    <? if (isset($auth) && $auth) { ?>
        <a href="#" class="post_icon_like" onclick="toggleLike(event);" data-pid="<?= htmlspecialchars($post->pid) ?>"><img class="post_icon" title="Like" src="<?=$like_src?>"/></a>
        <a href="#" class="post_icon_comment" onclick="focusComment(event);" data-pid="<?= htmlspecialchars($post->pid) ?>"><img class="post_icon" title="Comment" data-pid="<?= htmlspecialchars($post->pid) ?>"
                        src="/public/resources/icons/chat-1.png"/></a>
    <? } ?>
    <a href="#">
        <div class="post_user"><?= htmlspecialchars($post->username) ?></div>
    </a>
</div>
<div class="post_likes"><?= htmlspecialchars($post->likeCount) ?> likes</div>
