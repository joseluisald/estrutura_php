class HTTP
{
    static get(url, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const responseObject = JSON.parse(xhr.responseText);
                    callback(null, responseObject);
                } catch (error) {
                    callback(`Erro ao fazer o parse do JSON: ${error.message}`);
                }
            } else {
                callback(`Erro: ${xhr.status} - ${xhr.statusText}`);
            }
        };

        xhr.onerror = function () {
            callback('Erro de conexão');
        };

        xhr.send();
    }

    static request(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const responseObject = JSON.parse(xhr.responseText);
                    callback(null, responseObject);
                } catch (error) {
                    callback(`Erro ao fazer o parse do JSON: ${error.message}`);
                }
            } else {
                callback(`Erro: ${xhr.status} - ${xhr.statusText}`);
            }
        };

        xhr.onerror = function () {
            callback('Erro de conexão');
        };

        xhr.send(JSON.stringify(data));
    }

    static post(url, data, callback) {
        HTTP.request('POST', url, data, callback);
    }

    static put(url, data, callback) {
        HTTP.request('PUT', url, data, callback);
    }

    static delete(url, data, callback) {
        HTTP.request('DELETE', url, data, callback);
    }
}