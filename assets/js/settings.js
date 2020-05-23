'use strict';

let form = document.getElementById('settings');

if (form) {
    let button = document.getElementById('button');
    let about = document.getElementById('about');

    document.addEventListener('readystatechange', autosize);
    about.addEventListener('input', autosize);
    form.addEventListener('submit', deactivateButton);

    function autosize() {
        about.rows = 1;
        about.rows = (about.scrollHeight - 32) / 19;
    }

    function deactivateButton() {
        button.style.cursor = 'default';
        button.style.color = 'rgba(255, 255, 255, .5)';
        button.disabled = true;
    }
}