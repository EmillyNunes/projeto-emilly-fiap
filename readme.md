# Projeto FIAP Emilly
## Autor
[Emilly Nunes Simão Ferreira](www.linkedin.com/in/emilly-nunes)

## Índice
- [Descrição](#descrição)
- [Instalação](#instalação)
- [Tecnologias utilizadas no projeto](#tecnologias-utilizadas-no-projeto)
- [Lista de urls](#lista-de-urls)

## Descrição
O projeto tem como objetivo demonstrar conhecimentos técnicos para o processo seletivo da vaga de desenvolvimento da FIAP, sendo ele um portal de administração de alunos e turmas para a secretaria da FIAP.

## Instalação
Para o processo de instalação é importante seguir alguns passos
1. Acesse o repositório publico no github:
2. Clone o projeto localmente
3. Verifique se possui um docker instalado em sua máquina, caso não possua instale através do link: [https://docs.docker.com/engine/install/](https://docs.docker.com/engine/install/)
4. Certifique-se que o docker está instalado e o projeto foi clonado, e então acesse o repositório através de um terminal e digite o seguinte comando:
`docker-compose build`
5. Após a finalização do build rode o seguinte comando:
`docker-compose up -d `
6. Finalizando o processo, acesse seu navegador e insira a seguinte url:
`http://localhost:9000/login`
7. Para realizar o login utilize o seguinte usuário e senha:
`usuario: emilly.nunes@fiap.com.br `
`senha: emillyfiap`

## Tecnologias utilizadas no projeto
* Docker - Virtualizador de ambiente
* [FontAwesome](https://fontawesome.com/icons) - Biblioteca de ícones
* Javascript - Linguagem de programação
* MySQL 5.7 - Sistema de Gerencimento de banco de dados
* SCSS - Linguagem de estilo
* PHP 7.4 - Linguagem de programação


## Lista de urls

LOGIN

- http://localhost:9000/login - tela de login, responsável por permitir que administradores acessem o sistema através de usuario e senha.

DASHBOARD
- http://localhost:9000/dashboard - tela principal do dashboard, responsável por direcionar o administrador para visualização da ámrea de turmas ou de alunos.

TURMAS e MATRÍCULAS

- http://localhost:9000/turmas - visualização de todas as turmas cadastradas, principal tela desta área, possivel de se acessar através do dashboard selecionando turmas.
- http://localhost:9000/turmas/atualizar/{id} - visualização de edição de informações cadastrais referente a uma turma, para acessar é necessário clicar na opção de edição de uma turma na tabela de todas as turmas.
- http://localhost:9000/turmas/visualizar/{id} - visualização de uma turma, na página de visualização de todas as turmas, em ações, é possível clicar na opção de visualizar os detalhes a respeito desta turma, nesta área é possível visualizar as informações da turma, visualizar os alunos pertencentes a mesma, e se for necessário é possível inserir um novo aluno a essa turma através do botão para matricular aluno.
- http://localhost:9000/turmas/adicionar - tela responsável pelo cadastro de informações basicas relacionadas a turma, como nome, descrição e tipo.

ALUNOS

- http://localhost:9000/alunos - visualização de todos os alunos cadastrados, principal tela desta área,
possivel de se acessar através do dashboard selecionando alunos.
- http://localhost:9000/alunos/adicionar - tela responsável pelo cadastro de informações básicas sobre um aluno, como nome, data de nascimento, usuário e turma.
- http://localhost:9000/alunos/atualizar/{id} - visualização de um aluno, na página de visualização de todos os alunos na coluna de ação é possível ver o botão que direcionada para a área de atualização das informações de um aluno.
