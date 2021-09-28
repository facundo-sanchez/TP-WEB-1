'use strict'

document.querySelector('#formsend-news').addEventListener('submit', send_news);
document.querySelector('#formsend-category').addEventListener('submit', send_category);

document.querySelector('#category-button').addEventListener('click', form_category);
document.querySelector('#news-button').addEventListener('click', form_news);

function form_category() {



    //forms
    document.querySelector('#news-button').classList.remove('active');
    document.querySelector('#category-button').classList.add('active');
    document.querySelector('#formsend-news').classList.remove('d-block');
    document.querySelector('#formsend-news').classList.add('d-none');
    document.querySelector('#formsend-category').classList.remove('d-none');
    document.querySelector('#formsend-category').classList.add('d-block');
}

function form_news() {



    //forms
    document.querySelector('#category-button').classList.remove('active');
    document.querySelector('#news-button').classList.add('active');
    document.querySelector('#formsend-category').classList.remove('d-block');
    document.querySelector('#formsend-category').classList.add('d-none');
    document.querySelector('#formsend-news').classList.remove('d-none');
    document.querySelector('#formsend-news').classList.add('d-block');
}

function send_news(e) {
    e.preventDefault();
    const data = new URLSearchParams(new FormData(this));
    const url = 'send-news';
    server(data, url, true);

}

function send_category(e) {
    e.preventDefault();
    const data = new URLSearchParams(new FormData(this));
    const url = 'send-category';
    server(data, url, false);


}

async function server(data, url, news) {

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: data,
        })
        if (response.ok) {
            //setTimeout(reload_server, 1000);

            if (news === true) {
                succesSend_news();
                document.querySelector('#formsend-news').reset();
            } else {
                succesSend_category();
                document.querySelector('#formsend-category').reset();
            }


        }
    } catch (error) {
        console.log(error);
        if (news === true) {
            errorSend_news();
        } else {
            errorSend_category();
        }
    }
}

function reload_server() {
    location.reload();
}

function errorSend_news() {
    document.querySelector('#send-success-news').classList.add('d-none');
    document.querySelector('#send-error-news').classList.remove('d-none');
}

function succesSend_news() {
    document.querySelector('#send-error-news').classList.add('d-none');
    document.querySelector('#send-success-news').classList.remove('d-none');

}

function errorSend_category() {
    document.querySelector('#send-success-category').classList.add('d-none');
    document.querySelector('#send-error-category').classList.remove('d-none');
}

function succesSend_category() {
    document.querySelector('#send-error-category').classList.add('d-none');
    document.querySelector('#send-success-category').classList.remove('d-none');

}