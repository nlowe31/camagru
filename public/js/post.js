window.onscroll = function () {
    var posY = window.pageYOffset,
        winSize = window.innerHeight,
        pageSize = document.documentElement.scrollHeight,
        lastPost = _('feed').lastElementChild,
        lastID;

    if (posY + winSize > pageSize - 30) {
        if (Boolean(lastPost)) {
            lastID = lastPost.dataset.pid;
            ajax(scrollURL, ("last=" + lastID), function (response) {
                if (Boolean(response)) {
                    _('feed').insertAdjacentHTML('beforeend', response);
                    _('post_end').style.display = 'none';
                }
                else
                    _('post_end').style.display = 'block';
            });
        }
    }
};

function postComment(e) {
    e.preventDefault();
    var pid = e.currentTarget.dataset.pid,
        textbox,
        text;
    if (pid === undefined)
        return ;
    textbox = $('[class="post_new_comment_text"][data-pid="' + pid + '"]');
    if (textbox === undefined)
        return ;
    text = textbox.value;

    ajax("/post/postComment", ("pid=" + pid + "&text=" + text), function () {
        reloadComments(pid);
        textbox.value = '';
    });
}

function reloadComments(pid) {
    ajax("/post/loadComments", ("pid=" + pid), function (response) {
        $('[class="post_comments"][data-pid="' + pid + '"]').innerHTML = response;
    });
}

function toggleLike(e) {
    e.preventDefault();
    var pid = e.currentTarget.dataset.pid;
    if (pid === undefined)
        return ;
    ajax("/post/like", ("pid=" + pid), function (response) {
        $('[class="post_top"][data-pid="' + pid + '"]').innerHTML = response;
    });
}

function focusComment(e) {
    e. preventDefault();
    var pid = e.currentTarget.dataset.pid;
    if (pid === undefined)
        return ;
    $('[class="post_new_comment_text"][data-pid="' + pid + '"]').focus();
}