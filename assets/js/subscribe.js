'use strict';

let action = document.getElementById('action');

if (action) {
    action.addEventListener('click', clickAction);
}

function clickAction(event) {
    let button = event.target;

    if (button.id === 'subscribe' || button.id === 'unsubscribe') {
        deactivateButton(button)
        subscription(button.id, button);
    }
}

function subscription(act, button) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.pathname + '/' + act);
    xhr.send();

    xhr.onload = () => {
        if (xhr.status === 200) {
            let count = document.getElementsByClassName('count')[2];

            switch (act) {
                case 'subscribe':
                    count.innerText = Number(count.innerText) + 1;
                    break;
                case 'unsubscribe':
                    count.innerText = Number(count.innerText) - 1;
                    break;
            }

            action.innerHTML = xhr.response;
        } else {
            activateButton(button)
        }
    };

    xhr.onerror = () => {
        activateButton(button)
    };
}

function deactivateButton(button) {
    button.style.cursor = 'default';
    button.style.color = 'rgba(255, 255, 255, .5)';
    button.disabled = true;
}

function activateButton(button) {
    button.style.cursor = 'pointer';
    button.style.color = 'rgb(255, 255, 255)';
    button.disabled = false;
}