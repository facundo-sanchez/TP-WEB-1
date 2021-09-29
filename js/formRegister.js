'use strict'

document.querySelector('#form-register').addEventListener('submit', login);

function login(e) {
    e.preventDefault();

    const data = new URLSearchParams(new FormData(this));
    const url = 'register';
    console.log(data)
    server(data, url);

}
async function server(data, url) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: data,
        });
        if (response.ok) {
            console.log('registrado');
        }
    } catch (error) {
        console.log(error);
    }
}