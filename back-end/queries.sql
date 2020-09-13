CREATE DATABASE desafio_piperun;

USE desafio_piperun;

# Table de usuários
CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(150) UNIQUE NOT NULL,
    name VARCHAR(250),
    password VARCHAR(65) NOT NULL
);

# Tabela de tipos
CREATE TABLE types (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,

    user_id INT NOT NULL,

    foreign key(user_id) references users(id)
);

# Tabela de tarefas
CREATE TABLE tasks (
	id INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT NOT NULL,
    responsible VARCHAR(250) NOT NULL,
    start_at DATETIME DEFAULT CURRENT_TIMESTAMP, 	# inicio
    end_at DATETIME, 								# prazo
    finish_at DATETIME, 							# conclusão
    status BOOL DEFAULT 0,

    user_id INT NOT NULL,
    type_id INT,

    foreign key(user_id) references users(id),
    foreign key(type_id) references types(id)
);

# Inserir o primeiro usuário
INSERT INTO users VALUE(1, 'admin@piperun.com.br', 'Desafio PipeRun', '$2y$10$hu5QYPGc8j1vlpbwSzTUBO4FdfB1sTJx9LDRnERFAeHkcyLgU2E8u');

