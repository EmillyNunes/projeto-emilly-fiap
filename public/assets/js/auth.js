// Função para enviar requisições com o token JWT
function fetchWithAuth(url, options = {}) {
    const token = localStorage.getItem('authToken');

    // Adiciona o header Authorization se o token estiver presente
    if (token) {
        options.headers = {
            ...options.headers,
            'Authorization': `Bearer ${token}`
        };
    }

    return fetch(url, options);
}
