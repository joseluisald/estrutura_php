'use strict';

/**
 * class HTTP
 */
class HTTP
{
    /**
     * request
     * @param method
     * @param url
     * @param data
     * @param token
     * @param callback
     */
    static request(method, url, data, token = '', callback)
    {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);

        if (token) {
            xhr.setRequestHeader('Authorization', `Bearer ${token}`);
        }

        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const responseObject = JSON.parse(xhr.responseText || '{}');
                    callback(null, responseObject);
                } catch (error) {
                    callback(null, []);
                }
            } else {
                callback(`Erro: ${xhr.status} - ${xhr.statusText}`, null);
            }
        };

        xhr.onerror = function () {
            callback('Erro de conexão', null);
        };

        xhr.send(JSON.stringify(data));
    }

    /**
     * get
     * @param url
     * @param token
     * @param callback
     */
    static get(url, token = '', callback)
    {
        HTTP.request('GET', url, null, token, callback);
    }

    /**
     * post
     * @param url
     * @param data
     * @param token
     * @param callback
     */
    static post(url, data, token = '', callback)
    {
        HTTP.request('POST', url, data, token, callback);
    }

    /**
     * put
     * @param url
     * @param data
     * @param token
     * @param callback
     */
    static put(url, data, token = '', callback)
    {
        HTTP.request('PUT', url, data, token, callback);
    }

    /**
     * delete
     * @param url
     * @param token
     * @param callback
     */
    static delete(url, token = '', callback)
    {
        HTTP.request('DELETE', url, null, token, callback);
    }
}
