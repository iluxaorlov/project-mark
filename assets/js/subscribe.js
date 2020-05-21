'use strict';

let action = document.getElementById('action');

if (action) {
    action.addEventListener('click', clickAction);
}

function clickAction(event) {
    let element = event.target;
    let text = element.innerText;

    deactivateButton(element);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.pathname + '/' + element.id);
    xhr.send();

    xhr.onload = () => {
        if (xhr.status === 200) {
            action.innerHTML = xhr.response;
        } else {
            activateButton(element, text)
        }
    };

    xhr.onerror = () => {
        activateButton(element, text)
    };
}

function deactivateButton(button) {
    button.innerText = 'Подождите';
    button.style.color = 'rgba(255, 255, 255, .5)';
    button.disabled = true;
}

function activateButton(button, text) {
    button.innerText = text;
    button.style.color = 'rgb(255, 255, 255)';
    button.disabled = false;
}