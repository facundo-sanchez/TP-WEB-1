'use strict'
export default class FormSend {
    async server(data, url) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: data,
            })
            if (response.ok) {
                document.querySelector('#formsend-category').reset();
                return true;
            }
        } catch (error) {
            console.log(error);
            return false;

        }
    }
}