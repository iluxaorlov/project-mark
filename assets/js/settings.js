'use strict';

const form = document.getElementById('settings');

if (form) {
    const about = document.getElementById('about');
    const button = document.getElementById('button');

    document.addEventListener('readystatechange', autosize);

    about.addEventListener('input', autosize);

    form.addEventListener('submit', submit);

    function autosize() {
        about.rows = 1;
        about.rows = (about.scrollHeight - 32) / 19;
    }

    function submit() {
        button.innerText = 'Подождите';
        button.style.color = 'rgba(255, 255, 255, .5)';
        button.disabled = true;
    }
}