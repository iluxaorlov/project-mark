'use strict';

const form = document.getElementById('form');

if (form) {
    const button = document.getElementById('button');

    form.addEventListener('submit', () => {
        button.innerText = 'Подождите';
        button.style.color = 'rgba(255, 255, 255, .5)';
        button.disabled = true;
    });
}