window.onscroll = function () {
    var posY = window.pageYOffset,
        winSize = window.innerHeight,
        pageSize = document.documentElement.scrollHeight;

    if (posY + winSize > pageSize - 30) {
        ajax(scrollURL, ("last=" + last), function () {
            if (this.readyState === 4 && this.status === 200) {
                _('feed').insertAdjacentHTML('beforeend', this.responseText);
                last = _('feed').lastChild.dataset.pid;
            }
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
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === 'SUCCESS') {
                reloadComments(pid);
                textbox.value = '';
            }
        }
    });
}

function reloadComments(pid) {
    ajax("/post/loadComments", ("pid=" + pid), function () {
        if (this.readyState === 4 && this.status === 200) {
            $('[class="post_comments"][data-pid="' + pid + '"]').innerHTML = this.responseText;
        }
    });
}

function toggleLike(e) {
    e.preventDefault();
    var pid = e.currentTarget.dataset.pid;
    if (pid === undefined)
        return ;
    console.log($('[class="post_top"][data-pid="' + pid + '"]'));
    ajax("/post/like", ("pid=" + pid), function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log('response: ' + this.responseText);
            $('[class="post_top"][data-pid="' + pid + '"]').innerHTML = this.responseText;
        }
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