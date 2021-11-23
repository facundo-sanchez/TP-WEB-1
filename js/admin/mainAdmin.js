'use strict'
import FormStyles from './form-styles.js';
import FormSend from './formSend.js';

const formstyles = new FormStyles();
const formsend = new FormSend();

document.querySelector('#category-button').addEventListener('click', () => {
    formstyles.form_category();
});

document.querySelector('#news-button').addEventListener('click', () => {
    formstyles.form_news();
});

document.querySelector('#formsend-category').addEventListener('submit', getData);

function getData(e) {
    e.preventDefault();
    const data = new URLSearchParams(new FormData(this));
    const url = 'send-category';

    let response = formsend.server(data, url);
    if (response) {
        formstyles.succesSend_category();
        setTimeout(formstyles.reload_server, 500);
    } else {
        formstyles.errorSend_category();

    }
}