"use strict"

let app = new Vue({
    el: '#comments',
    data: {
        comments: [],
    }
});


let form = document.querySelector('#form');
if (form != null) {
    form.addEventListener('submit', addComments);
}

document.querySelector('#filter_delete').addEventListener('click', getComments);

let btn_data_filter = document.querySelectorAll('.dropdown-item');
for (const btn of btn_data_filter) {
    btn.addEventListener('click', filter);
}


function filter(e) {
    let data = e.target.dataset.filter;
    if (data) {
        filterComments(data);
    } else {
        let order = e.target.dataset.order;
        let option = e.target.dataset.option;
        orderComments(order, option);
    }
}

async function getComments() {
    hide_danger_filter();
    hide_warning_filter();

    const urlParams = window.location.href;
    let params = urlParams.split('/');
    const API_URL = 'api/comments/' + params[5];

    try {
        const response = await fetch(API_URL);
        const json = await response.json();
        if (response.ok) {
            app.comments = json;
            setTimeout(dataDelete, 100);
        }

    } catch (error) {
        console.log(error);
        show_danger_filter();
    }
}

async function addComments(e) {
    hide_danger_filter();

    const API_URL_POST = 'api/comments/';
    e.preventDefault();
    let data = new FormData(this);

    let comment = {
        id_news: data.get('id_news'),
        points: data.get('points'),
        comment: data.get('comment'),
    }

    try {
        const response = await fetch(API_URL_POST, {
            method: "POST",
            headers: { "Content-Type": "application/json", },
            body: JSON.stringify(comment),
        });

        if (response.ok) {
            const json = await response.json();
            app.comments.unshift(json);
            setTimeout(dataDelete, 100);
            document.querySelector("#form").reset();
        }
    } catch (error) {
        console.log(error);
    }
}

async function deleteComments(e) {
    hide_danger_filter()

    let data_id = e.target.dataset.id;
    const API_URL_DELETE = 'api/comments/' + data_id;

    if (data_id) {
        try {
            const response = await fetch(API_URL_DELETE, {
                method: 'DELETE',
            });
            if (response.ok) {
                if (app.comments.length === 1) {
                    app.comments = [];
                } else {
                    getComments();
                }
            }
        } catch (error) {
            console.log(error)
            show_danger_filter();
        }
    }
}

async function filterComments(data) {
    hide_danger_filter()
    const urlParams = window.location.href;
    let params = urlParams.split('/');
    const API_URL_FILTER = 'api/comments/filter/' + params[5] + '/' + data;
    app.comments = [];

    try {
        const response = await fetch(API_URL_FILTER);
        if (response.ok) {
            const json = await response.json();
            app.comments = json;
            show_warning_filter();
            setTimeout(dataDelete, 100);
        } else {
            hide_warning_filter();
            show_danger_filter()
        }

    } catch (e) {
        console.log(e);
    }
}

async function orderComments(order, option) {
    const urlParams = window.location.href;
    let params = urlParams.split('/');
    const API_URL_ORDER = 'api/comments/order/' + params[5] + '/' + order + '/' + option;
    try {
        const response = await fetch(API_URL_ORDER);
        if (response.ok) {
            const json = await response.json();
            app.comments = json;
        }

    } catch (e) {
        console.log(error);
    }
}

function dataDelete() {
    let btn_data_delete = document.querySelectorAll('button');

    for (const btn of btn_data_delete) {
        btn.addEventListener('click', deleteComments);
    }
}

function show_warning_filter() {
    document.querySelector('#alert_filter').classList.remove('d-none');
    document.querySelector('#alert_filter').classList.add('d-block');
}

function hide_warning_filter() {
    document.querySelector('#alert_filter').classList.remove('d-block');
    document.querySelector('#alert_filter').classList.add('d-none');
}

function show_danger_filter() {
    document.querySelector('#filter_not_found').classList.remove('d-none');
    document.querySelector('#filter_not_found').classList.add('d-block');
}

function hide_danger_filter() {
    document.querySelector('#filter_not_found').classList.remove('d-block');
    document.querySelector('#filter_not_found').classList.add('d-none');
}

getComments();