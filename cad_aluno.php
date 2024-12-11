<?php
session_start();
require 'conexao.php';

if (isset($_POST['acao'])) {
    $nome_completo = trim($_POST['nome_completo']);
    $cpf = trim($_POST['cpf']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $endereco = trim($_POST['endereco']);
    $contato = trim($_POST['contato']);
    $plano_id = trim($_POST['plano_id']);
    $situacao = trim($_POST['situacao']);
    $nome_usuario = trim($_POST['nome_usuario']);
    $senha = trim($_POST['senha']);
    $perfil = trim($_POST['perfil']);

    if (empty($nome_completo)) {
        $erro = 'O nome do aluno não pode ficar vazio!';
    } elseif (empty($nome_usuario)) {
        $erro = 'O nome de usuário não pode ficar vazio!';
    } elseif (empty($senha)) {
        $erro = 'A senha não pode ficar vazia.';
    } else {
        try {
            $pdo->beginTransaction();

            $sql_alunos = $pdo->prepare("INSERT INTO alunos (nome_completo, cpf, data_nascimento, endereco, contato, plano_id, situacao) VALUES (:nome_completo, :cpf, :data_nascimento, :endereco, :contato, :plano_id, :situacao)");
            $sql_alunos->bindValue(':nome_completo', $nome_completo);
            $sql_alunos->bindValue(':cpf', $cpf);
            $sql_alunos->bindValue(':data_nascimento', $data_nascimento);
            $sql_alunos->bindValue(':endereco', $endereco);
            $sql_alunos->bindValue(':contato', $contato);
            $sql_alunos->bindValue(':plano_id', $plano_id);
            $sql_alunos->bindValue(':situacao', $situacao);
            $sql_alunos->execute();

            $sql_usuarios = $pdo->prepare("INSERT INTO usuarios (nome_usuario, senha, perfil) VALUES (:nome_usuario, :senha, :perfil)");
            $sql_usuarios->bindValue(':nome_usuario', $nome_usuario);
            $sql_usuarios->bindValue(':senha', $senha); 
            $sql_usuarios->bindValue(':perfil', $perfil);
            $sql_usuarios->execute();

            $pdo->commit();

            $_SESSION['mensagem_sucesso'] = 'Aluno cadastrado com sucesso!';
        } catch (Exception $e) {
            $pdo->rollBack();
            $erro = 'Erro ao cadastrar aluno: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Power House Academia</title>
    <link rel="icon" href="imagens/logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: "Poppins", sans-serif;
        }

        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: LightSkyBlue;
        }

        main {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .sair {
            margin: 10px;
        }

        .alert {
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .form-container {
            width: 100%;
            max-width: 900px;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            min-width: 40px;
        }

        footer {
            background-color: DodgerBlue;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .alert {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary " style="box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.25)">
            <div class="container-fluid">
                <a class="navbar-brand" href="home_admin.php"><img id="imagens" src="imagens/logo.png" width="60"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home_admin.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cad_aluno.php">CADASTRO DE ALUNOS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INSTRUTORES
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="cad_prof.php">CADASTRO DE INSTRUTORES</a></li>
                                <li><a class="dropdown-item" href="instrutores.php">QUADRO DE COLABORADORES</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="financeiro.php">FINANCEIRO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="planos.php">PLANOS</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sair">
                <button type="button" class="btn btn-primary"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><a href="index.php" style="color: white; text-decoration: none;">Sair</a>
                </button>
            </div>
        </nav>
    </header>
    <main>
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger" role="alert"><?= $erro ?></div>
        <?php elseif (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success" role="alert"><?= $_SESSION['mensagem_sucesso'] ?></div>
            <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>
        <form method="post" class="row g-3">
            <form class="row g-3 needs-validation" novalidate>
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" required>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom03" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom03" class="form-label">Contato</label>
                    <input type="text" class="form-control" id="contato" name="contato" required>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">Tipo de Plano</label>
                    <select class="form-select" id="plano_id" name="plano_id" required>
                        <option selected disabled value="">Tipo de Plano</option>
                        <option value="1">House Blue</option>
                        <option value="2">House Gold</option>
                        <option value="3">House Premium</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Data de Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">Situação do Aluno</label>
                    <select class="form-select" id="situacao" name="situacao" required>
                        <option>Ativo</option>
                        <option>Inativo</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">Nome de Usuário</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="nome_usuario">@</span>
                        <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" aria-describedby="inputGroupPrepend" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">Perfil</label>
                    <select class="form-select" id="perfil" name="perfil" required>
                        <option>Aluno</option>
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" name="acao">Enviar Dados</button>
                </div>
            </form>
        </form>
    </main>
    <footer>
        <small>Power House Academia &copy; <?= date('Y'); ?></small>
    </footer>
</body>

</html>