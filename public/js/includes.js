function $(query) {
    return (document.querySelector(query));
}

function _(id) {
    return (document.getElementById(id));
}

function ajax(url, data, success) {
    var request = new XMLHttpRequest();
    request.onerror = function() {
        console.log('Ajax request to ' + url + ' produced an error.');
    };
    request.onload = function () {
        console.log('Ajax request to ' + url + ' returned successfully.');
        if (this.responseText === 'ERROR') {
            console.log('Server-side error reported for ajax request to ' + url + '.');
        }
        else {
            success(this.responseText);
        }
    };
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
}

function onEnter(f, e) {
    if (e.keyCode === 13)
        f(e);
}

function addEventListenerToClass(className, event, f) {
    var classElements = document.getElementsByClassName(className);
    for (var i = 0; i < classElements.length; i++) {
        classElements[i].addEventListener(event, f, false);
    }
}