window.onscroll = function () {
    var posY = window.pageYOffset,
        winSize = window.innerHeight,
        pageSize = document.documentElement.scrollHeight;

    if (posY + winSize > pageSize - 30) {
        ajax(scrollURL, ("last=" + last), function (response) {
            _('feed').insertAdjacentHTML('beforeend', response);
            last = _('feed').lastChild.dataset.pid;
        });
    }
};

function postComment(e) {
    e.preventDefault();
    var pid = e.currentTarget.dataset.pid,
        textbox,
        text;
    console.log(pid);
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
    console.log(pid);
    if (pid === undefined)
        return ;
    $('[class="post_new_comment_text"][data-pid="' + pid + '"]').focus();
}