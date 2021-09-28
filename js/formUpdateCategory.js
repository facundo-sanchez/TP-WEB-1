document.querySelector('#formupdate-category').addEventListener('submit', update_category);

function update_category(e) {
    e.preventDefault();
    const data = new URLSearchParams(new FormData(this));
    const url = 'update-category';
    server(url, data);
}

async function server(url, data) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        if (response.ok) {
            document.querySelector('#formupdate-category').classList.add('d-none');
            document.querySelector('#content-update').classList.remove('d-none');
            document.querySelector('#content-update').classList.add('d-block');
        }
    } catch (error) {
        console.log(error);
        document.querySelector('#error-update').classList.remove('d-none');

    }
}