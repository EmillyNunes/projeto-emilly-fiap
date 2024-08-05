<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title>Formulário de Login</title>
</head>

<body>
    <section id="login">
        <div class="containt-login">
            <h1>Login</h1>
            <div class="login-container">
                <form id="loginForm" method="POST">
                    <input type="text" name="email" id="email" placeholder="Nome do usuário" required>
                    <input type="password" name="senha" id="senha" placeholder="Senha" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
    document.getElementById('loginForm').addEventListener('submit', async function (event) {
        event.preventDefault(); // Previne o comportamento padrão do formulário

        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    senha: senha
                })
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Resposta do servidor:', result);

                // Verifica se a resposta contém um token
                if (result.token) {
                    // Armazena o token no localStorage
                    localStorage.setItem('authToken', result.token);
                    console.log('Token armazenado:', result.token); // Log para depuração
                    // Redireciona para a página de turmas
                    window.location.href = '/dashboard';
                } else {
                    // Mostra uma mensagem de erro se o token não estiver presente
                    alert('Token não recebido. Tente novamente.');
                }
            } else {
                // Caso o servidor retorne um erro, exibe a mensagem de erro
                const error = await response.json();
                console.error('Erro da resposta:', error);
                alert(error.error || 'Ocorreu um erro ao fazer login.');
            }
        } catch (error) {
            console.error('Erro ao fazer login:', error);
            alert('Ocorreu um erro ao fazer login. Confira o console para mais detalhes.');
        }
    });

</script>


</html>