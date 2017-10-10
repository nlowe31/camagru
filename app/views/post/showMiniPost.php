<div class="mini_post" data-pid="<?= htmlspecialchars($post->pid) ?>">
    <img class="mini_post_photo" src="<?= htmlspecialchars($post->src) ?>"/>
    <div class="mini_post_overlay" onclick="deletePost(event);" data-pid="<?= htmlspecialchars($post->pid) ?>">
        <img class="mini_post_overlay_icon" src="/public/resources/icons/garbage.png">
    </div>
</div>