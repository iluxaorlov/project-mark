'use strict';

let form = document.getElementById('form');

if (form) {
    let button = document.getElementById('button');

    form.addEventListener('submit', deactivateButton);

    function deactivateButton() {
        button.style.cursor = 'default';
        button.style.color = 'rgba(255, 255, 255, .5)';
        button.disabled = true;
    }
}