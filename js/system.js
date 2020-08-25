function isDefined(v) {
    return typeof v !== "undefined" && v !== null;
}

function triggerEvent(el, name, params) {
    let event = new CustomEvent(name);
    event.data = params;

    el.dispatchEvent(event)
}

function ajax(url, data, onOK, onError) {
    let xhr = new XMLHttpRequest();

    let queryStr = []
    for (let [key, value] of Object.entries(data)) {
        if (isDefined(value)) {
            if (typeof value == "object") {
                value = JSON.stringify(value)
            }
            queryStr.push(key + '=' + value)
        }
    }

    triggerEvent(document, 'ajax_start', queryStr);

    let resultQueryStr = queryStr.join('&');

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    showProgress();

    xhr.onload = function () {
        if (xhr.status === 200) {
            if (onOK) {
                triggerEvent(document, 'ajax_success', queryStr);
                onOK(xhr.response);

                hideProgress()
            }
        } else {
            if (onError) {
                triggerEvent(document, 'ajax_error', queryStr);
                onError(xhr)

                hideProgress()
            }
        }
        triggerEvent(document, 'ajax_stop', queryStr);
    };

    xhr.send(encodeURI(resultQueryStr));
}

function showProgress() {
    document.querySelector('.progress-indicator').style.display = 'block';
}

function hideProgress() {
    document.querySelector('.progress-indicator').style.display = 'none';
}
