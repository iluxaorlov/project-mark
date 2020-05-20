'use strict';

let action = document.getElementById('action');

if (action) {
    action.addEventListener('click', (event) => {
        let element = event.target;
        let innerText = element.innerText;

        element.innerText = 'Подождите';
        element.style.color = 'rgba(255, 255, 255, .5)';
        element.disabled = true;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.pathname + '/' + element.id);
        xhr.send();

        xhr.onload = () => {
            if (xhr.status === 200) {
                action.innerHTML = xhr.response;
            } else {
                element.innerText = innerText;
                element.style.color = 'rgb(255, 255, 255)';
                element.disabled = false;
            }
        };
    });
}