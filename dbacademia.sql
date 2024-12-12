CREATE DATABASE dbacademia;
USE dbacademia;

CREATE TABLE Planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(255) NOT NULL,
    valor_mensal DECIMAL(10,2) NOT NULL,
    duracao VARCHAR(100),
    beneficios TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    data_nascimento DATE NOT NULL,
    endereco TEXT,
    contato VARCHAR(15),
    plano_id INT,
    data_inicio DATE,
    situacao ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (plano_id) REFERENCES Planos(id)
);

CREATE TABLE Instrutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    formacao VARCHAR(255),
    especializacoes TEXT,
    horario_trabalho TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_aula VARCHAR(255) NOT NULL,
    horario TIME NOT NULL,
    instrutor_id INT,
    lotacao_maxima INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instrutor_id) REFERENCES Instrutores(id)
);

CREATE TABLE Equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL,
    estado ENUM('Em uso', 'Manutenção') DEFAULT 'Em uso',
    data_aquisicao DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    data_vencimento DATE NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    status_pagamento ENUM('Pago', 'Pendente', 'Atrasado') DEFAULT 'Pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES Alunos(id)
);

CREATE TABLE Treinos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    instrutor_id INT,
    descricao TEXT,
    data_inicio DATE,
    data_fim DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES Alunos(id),
    FOREIGN KEY (instrutor_id) REFERENCES Instrutores(id)
);

CREATE TABLE Agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    aula_id INT,
    data_agendamento DATE NOT NULL,
    status ENUM('Confirmado', 'Cancelado', 'Pendente') DEFAULT 'Pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (aluno_id) REFERENCES Alunos(id),
    FOREIGN KEY (aula_id) REFERENCES Aulas(id)
);
alter table Agendamentos change status situacao ENUM('Confirmado', 'Cancelado', 'Pendente') DEFAULT 'Pendente';

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Administrador', 'Instrutor', 'Aluno') DEFAULT 'Aluno',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

insert into usuarios(nome_usuario, senha, perfil)
values('admTeste', 'teste123', 'Administrador');

INSERT INTO planos(nome_plano, valor_mensal, duracao, beneficios)
values('Recorrente House Blue', 100.00, 'Mensal', 'Acesso a todas as aulas coletivas, Sem multas ou taxas de cancelamento, Acesso total a estrutura da academia, Sem restrição de horários.'),
('Recorrente House Gold', 129.90, 'Mensal', 'Acesso a todas as aulas coletivas, Acesso total a estrutura da academia, Sem restrição de horários, Treino em todas as unidades Bluefit, Fidelidade de 12 meses.'),
('Recorrente House Premium', 159.90, 'Mensal', 'Acesso a todas as aulas coletivas, Sem multas ou taxas de cancelamento, Acesso total a estrutura da academia, Sem restrição de horários, Treino em todas as unidades Bluefit, Taxa zero');

INSERT INTO aulas(nome_aula, horario, instrutor_id, lotacao_maxima)
VALUES('Cross Fit', '06:00:00', 2, 30),
('Boxe', '07:30:00', 3, 10),
('RPM', '09:00:00', 4, 30);

