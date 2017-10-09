function $(query) {
    return (document.querySelector(query));
}

function _(id) {
    return (document.getElementById(id));
}

function ajax(url, data, f) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = f;
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);
}

function addEventListenerToClass(className, event, f) {
    var classElements = document.getElementsByClassName(className);
    for (var i = 0; i < classElements.length; i++) {
        classElements[i].addEventListener(event, f, false);
    }
}