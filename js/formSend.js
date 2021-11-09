'use strict'

//document.querySelector('#formsend-news').addEventListener('submit', send_news);
document.querySelector('#formsend-category').addEventListener('submit', send_category);
/*
function send_news(e) {
    e.preventDefault();
    const data = new URLSearchParams(new FormData(this));
    let news = {
        title: data.get('title_news'),
        img: data.get('input_file'),
        description: data.get('description_news'),
        id_category: ('category_news')
    }
    const url = 'send-news';
    server(data, url, true);
}
*/
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
            setTimeout(reload_server, 500);

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