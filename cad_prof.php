<?php
session_start();

require 'conexao.php';

if (isset($_POST['acao'])) {
    $nome_completo = $_POST['nome_completo'];
    $formacao = $_POST['formacao'];
    $especializacoes = $_POST['especializacoes'];
    $horario_trabalho = $_POST['horario_trabalho'];
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];

    if (empty($nome_completo)) {
        $erro = 'O nome do professor não pode ficar vazio!';
    } elseif (empty($nome_usuario)) {
        $erro = 'O nome de usuário não pode ficar vazio!';
    } elseif (empty($senha)) {
        $erro = 'A senha não pode ficar vazia.';
    } else {
        try {
            $pdo->beginTransaction();

            $sql = $pdo->prepare("INSERT INTO instrutores (nome_completo, formacao, especializacoes, horario_trabalho) VALUES (:nome_completo, :formacao, :especializacoes, :horario_trabalho)");
            $sql->bindValue(':nome_completo', $nome_completo);
            $sql->bindValue(':formacao', $formacao);
            $sql->bindValue(':especializacoes', $especializacoes);
            $sql->bindValue(':horario_trabalho', $horario_trabalho);
            $sql->execute();

            $sql = $pdo->prepare("INSERT INTO usuarios (nome_usuario, senha, perfil) VALUES (:nome_usuario, :senha, :perfil)");
            $sql->bindValue(':nome_usuario', $nome_usuario);
            $sql->bindValue(':senha', $senha);
            $sql->bindValue(':perfil', $perfil);
            $sql->execute();
            $pdo->commit();

         $_SESSION['mensagem_sucesso'] = 'Instrutor cadastrado com sucesso!';
        } catch (Exception $e) {
            $pdo->rollBack();
            $erro = 'Erro ao cadastrar instrutor: ' . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power House Academia</title>
    <link rel="icon" href="imagens/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        }

        .sair {
            margin: 10px;
        }

        footer {
            background-color: DodgerBlue;
            color: white;
            text-align: center;
            padding: 10px;
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
                            <a class="nav-link" href="cad_aluno.php">CADASTRO DE ALUNOS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <div class="col-md-4">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome_completo" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Formação</label>
                <input type="text" name="formacao" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Especializações</label>
                <input type="text" name="especializacoes" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Horário de Trabalho</label>
                <input type="text" name="horario_trabalho" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nome de Usuário</label>
                <input type="text" name="nome_usuario" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Perfil</label>
                <select name="perfil" class="form-select" required>
                    <option>Instrutor</option>
                    <option>Administrador</option>
                </select>
            </div>
            <div class="col-12"><button class="btn btn-primary" type="submit" name="acao">Enviar Dados</button></div>
        </form>
    </main>
    <footer>
        <small>Power House Academia &copy; <?= date('Y'); ?></small>
    </footer>
</body>

</html>