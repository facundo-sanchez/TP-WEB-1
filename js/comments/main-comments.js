'use strict'

import ApiComments from './api-comments.js';

const comments = new ApiComments();

let comment_id = document.querySelector('#comments');
let data_comment = comment_id.dataset.comment;

document.querySelector('#search-comment').addEventListener('submit', getdatafilter);

document.querySelector('#filter_delete').addEventListener('click', () => {
    comments.getComments(data_comment);
});

let form = document.querySelector('#form');
if (form != null) {
    form.addEventListener('submit', getData);
}

comments.getComments(data_comment);
setTimeout(dataDelete, 100);


function getData(e) {
    e.preventDefault();
    let data = new FormData(this);

    let comment = {
        id_news: data.get('id_news'),
        points: data.get('points'),
        comment: data.get('comment'),
    }
    comments.addComments(comment, data_comment);
    setTimeout(dataDelete, 100);
    document.querySelector('#form').reset();
}

function dataDelete() {
    let btn_data_delete = document.querySelectorAll('.btn-danger');

    for (const btn of btn_data_delete) {
        btn.addEventListener('click', e => {
            comments.deleteComments(e, data_comment);
        });
    }
}

function getdatafilter(e) {
    e.preventDefault();

    let form_data = new FormData(this);
    let order = form_data.get('order');
    let filter = form_data.get('points');
    comments.filter_Order(filter, order, data_comment);
    setTimeout(dataDelete, 100);
}