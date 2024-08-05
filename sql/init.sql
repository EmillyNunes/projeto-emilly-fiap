-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS db_fiap;

-- Usa o banco de dados criado (db_fiap)
USE db_fiap;

-- Cria a tabela de administradores 
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cria a tabela de alunos
CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL
);

-- Cria a tabela de turmas
CREATE TABLE IF NOT EXISTS turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    tipo VARCHAR(50) NOT NULL
);

-- Cria a tabela de matrículas com exclusão em cascata
CREATE TABLE IF NOT EXISTS matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT,
    id_turma INT,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_turma) REFERENCES turmas(id) ON DELETE CASCADE
);

-- Insere dados na tabela de alunos
INSERT INTO alunos (nome, email, data_nascimento) VALUES ('João da Silva', 'joao@example.com', '2002-02-15');
INSERT INTO alunos (nome, email, data_nascimento) VALUES ('Maria Oliveira', 'maria@example.com', '2000-06-20');
INSERT INTO alunos (nome, email, data_nascimento) VALUES ('Carlos Santos', 'carlos@example.com', '2001-04-10');

-- Insere dados na tabela de turmas
INSERT INTO turmas (nome, descricao, tipo) VALUES ('Data Science', 'Curso de Data Science', 'Graduação');
INSERT INTO turmas (nome, descricao, tipo) VALUES ('IA Para Devs', 'Curso de IA para Devs', 'Pós Graduação');
INSERT INTO turmas (nome, descricao, tipo) VALUES ('AI Business Leadership', 'Curso de AI Business Leadership', 'MBA');

-- Matricula alunos em turmas
INSERT INTO matriculas (id_aluno, id_turma) VALUES (1, 1); -- João em Matemática
INSERT INTO matriculas (id_aluno, id_turma) VALUES (2, 2); -- Maria em História
INSERT INTO matriculas (id_aluno, id_turma) VALUES (3, 3); -- Carlos em Ciências

-- Adiciona um administrador
INSERT INTO admins (email, password_hash) VALUES ('emilly.nunes@fiap.com.br', '$2y$10$yrU2bRmRqVUghxudoI8mteAKxl6ZeFmZiHJipplRRh1ZQY6fuKyYS');
