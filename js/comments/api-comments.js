"use strict"

let app = new Vue({
    el: '#comments',
    data: {
        comments: [],
    }
});

const API_URL = 'api/news/comments/';

export default class ApiComments {

    async getComments(data_comment) {
        hide_danger_filter();
        hide_warning_filter();

        try {
            const response = await fetch(API_URL + data_comment);
            if (response.status === 200) {
                const json = await response.json();
                app.comments = json;

            } else if (response.status === 204) {
                show_danger_filter()
            }

        } catch (error) {
            console.log(error);
            show_danger_filter();
        }
    }

    async addComments(comment, data_comment) {
        hide_danger_filter();

        if (comment.points >= 1 && comment.points <= 5 && comment.comment != '') {
            try {
                const response = await fetch(API_URL, {
                    method: "POST",
                    headers: { "Content-Type": "application/json", },
                    body: JSON.stringify(comment),
                });

                if (response.ok) {
                    const json = await response.json();
                    comments.getComments(data_comment);
                    document.querySelector("#form").reset();
                }

            } catch (error) {
                console.log(error);
            }
        }
    }

    async deleteComments(e, data_comment) {
        hide_danger_filter()
        let data_id = e.target.dataset.id;

        if (data_id) {
            try {
                const response = await fetch(API_URL + data_id, {
                    method: 'DELETE',
                });
                if (response.ok) {
                    if (app.comments.length === 1) {
                        app.comments = [];
                    } else {
                        comments.getComments(data_comment);
                    }
                } else if (response.status === 204) {
                    show_danger_filter()
                }
            } catch (error) {
                console.log(error)
                show_danger_filter();
            }
        }
    }

    filter_Order(filter, order, data_comment) {
        if ((order == 'asc-date') || (order == 'des-date') || (order == 'asc-point') || (order == 'des-point')) {
            comments.orderComments(order, data_comment);
        } else if (order == 'none') {
            if (filter >= 1 && filter <= 5) {
                comments.filterComments(filter, data_comment);
            }
        }
    }

    async filterComments(filter, data_comment) {
        hide_danger_filter();
        hide_danger_filter();

        app.comments = [];

        try {
            const response = await fetch(API_URL + data_comment + '/?points=' + filter);
            if (response.status === 200) {
                const json = await response.json();
                app.comments = json;

                show_warning_filter();

            } else if (response.status === 204) {
                show_danger_filter()
            }

        } catch (e) {
            console.log(e);
            hide_warning_filter();
            show_danger_filter()
        }
    }

    async orderComments(order, data_comment) {
        hide_warning_filter();
        hide_danger_filter();

        try {
            const response = await fetch(API_URL + data_comment + '/?order=' + order);
            if (response.status === 200) {
                const json = await response.json();
                app.comments = json;
                document.querySelector('#search-comment').reset();
            } else if (response.status === 204) {
                show_danger_filter()
            }

        } catch (e) {
            console.log(error);
        }
    }
}


const comments = new ApiComments();


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