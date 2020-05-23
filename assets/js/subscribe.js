'use strict';

let action = document.getElementById('action');

if (action) {
    action.addEventListener('click', clickAction);
}

function clickAction(event) {
    let button = event.target;
    let buttonText = button.innerText;

    deactivateButton();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.pathname + '/' + button.id);
    xhr.send();

    xhr.onload = () => {
        if (xhr.status === 200) {
            action.innerHTML = xhr.response;

            let count = document.getElementsByClassName('count')[2];

            switch (button.id) {
                case 'subscribe':
                    count.innerText = Number(count.innerText) + 1;
                    break;
                case 'unsubscribe':
                    count.innerText = Number(count.innerText) - 1;
                    break;
            }
        } else {
            activateButton()
        }
    };

    xhr.onerror = () => {
        activateButton()
    };

    function deactivateButton() {
        button.innerText = 'Подождите';
        button.style.cursor = 'default';
        button.style.color = 'rgba(255, 255, 255, .5)';
        button.disabled = true;
    }

    function activateButton() {
        button.innerText = buttonText;
        button.style.cursor = 'pointer';
        button.style.color = 'rgb(255, 255, 255)';
        button.disabled = false;
    }
}