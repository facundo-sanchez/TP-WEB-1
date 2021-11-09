'use strict'
document.querySelector('#category-button').addEventListener('click', form_category);
document.querySelector('#news-button').addEventListener('click', form_news);

document.querySelector('#box-news-button').addEventListener('click', box_news);
document.querySelector('#box-category-button').addEventListener('click', box_category);

function form_category() {
    document.querySelector('#news-button').classList.remove('active');
    document.querySelector('#category-button').classList.add('active');
    document.querySelector('#formsend-news').classList.remove('d-block');
    document.querySelector('#formsend-news').classList.add('d-none');
    document.querySelector('#formsend-category').classList.remove('d-none');
    document.querySelector('#formsend-category').classList.add('d-block');
}

function form_news() {
    document.querySelector('#category-button').classList.remove('active');
    document.querySelector('#news-button').classList.add('active');
    document.querySelector('#formsend-category').classList.remove('d-block');
    document.querySelector('#formsend-category').classList.add('d-none');
    document.querySelector('#formsend-news').classList.remove('d-none');
    document.querySelector('#formsend-news').classList.add('d-block');
}

function box_news() {
    document.querySelector('#box-category-button').classList.remove('active');
    document.querySelector('#box-news-button').classList.add('active');
    document.querySelector('#box_category').classList.remove('active');
    document.querySelector('#box_category').classList.remove('d-block');
    document.querySelector('#box_category').classList.add('d-none');
    document.querySelector('#box_news').classList.remove('d-none');
    document.querySelector('#box_news').classList.add('d-block');
}

function box_category() {
    document.querySelector('#box-news-button').classList.remove('active');
    document.querySelector('#box-category-button').classList.add('active');
    document.querySelector('#box_news').classList.remove('d-block');
    document.querySelector('#box_news').classList.add('d-none');
    document.querySelector('#box_category').classList.remove('d-none');
    document.querySelector('#box_category').classList.add('d-block');

}