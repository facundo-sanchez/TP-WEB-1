'use strict'

export default class FormStyles {

    form_category() {
        document.querySelector('#news-button').classList.remove('active');
        document.querySelector('#category-button').classList.add('active');
        document.querySelector('#formsend-news').classList.remove('d-block');
        document.querySelector('#formsend-news').classList.add('d-none');
        document.querySelector('#formsend-category').classList.remove('d-none');
        document.querySelector('#formsend-category').classList.add('d-block');
    }

    form_news() {
        document.querySelector('#category-button').classList.remove('active');
        document.querySelector('#news-button').classList.add('active');
        document.querySelector('#formsend-category').classList.remove('d-block');
        document.querySelector('#formsend-category').classList.add('d-none');
        document.querySelector('#formsend-news').classList.remove('d-none');
        document.querySelector('#formsend-news').classList.add('d-block');
    }

    box_news() {
        document.querySelector('#box-category-button').classList.remove('active');
        document.querySelector('#box-news-button').classList.add('active');
        document.querySelector('#box_category').classList.remove('active');
        document.querySelector('#box_category').classList.remove('d-block');
        document.querySelector('#box_category').classList.add('d-none');
        document.querySelector('#box_news').classList.remove('d-none');
        document.querySelector('#box_news').classList.add('d-block');
    }

    box_category() {
        document.querySelector('#box-news-button').classList.remove('active');
        document.querySelector('#box-category-button').classList.add('active');
        document.querySelector('#box_news').classList.remove('d-block');
        document.querySelector('#box_news').classList.add('d-none');
        document.querySelector('#box_category').classList.remove('d-none');
        document.querySelector('#box_category').classList.add('d-block');

    }
    reload_server() {
        location.reload();
    }

    errorSend_news() {
        document.querySelector('#send-success-news').classList.add('d-none');
        document.querySelector('#send-error-news').classList.remove('d-none');
    }

    succesSend_news() {
        document.querySelector('#send-error-news').classList.add('d-none');
        document.querySelector('#send-success-news').classList.remove('d-none');
    }

    errorSend_category() {
        document.querySelector('#send-success-category').classList.add('d-none');
        document.querySelector('#send-error-category').classList.remove('d-none');
    }

    succesSend_category() {
        document.querySelector('#send-error-category').classList.add('d-none');
        document.querySelector('#send-success-category').classList.remove('d-none');
    }
}