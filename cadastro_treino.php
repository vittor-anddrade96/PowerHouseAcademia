<?php
session_start();
require 'conexao.php';

$sql = $pdo->prepare("SELECT * FROM alunos");
$sql->execute();
$lista = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['acao'])) {
    $aluno_id = trim($_POST['aluno_id']);
    $instrutor_id = trim($_POST['instrutor_id']);
    $descricao = trim($_POST['descricao']);
    $data_inicio = ($_POST['data_inicio']);
    $data_fim = ($_POST['data_fim']);

    try {
        $pdo->beginTransaction();

        $sql = $pdo->prepare("INSERT INTO treinos (aluno_id, instrutor_id, descricao, data_inicio, data_fim) VALUES (:aluno_id, :instrutor_id, :descricao, :data_inicio, :data_fim)");
        $sql->bindValue(':aluno_id', $aluno_id);
        $sql->bindValue(':instrutor_id', $instrutor_id);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':data_inicio', $data_inicio);
        $sql->bindValue(':data_fim', $data_fim);
        $sql->execute();

        $pdo->commit();
        $_SESSION['mensagem_sucesso'] = 'Treino cadastrado com sucesso!';
    } catch (Exception $e) {
        $pdo->rollBack();
        $erro = 'Erro ao cadastrar treino: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.25)">
            <div class="container-fluid">
                <a class="navbar-brand" href="home_prof.php"><img src="imagens/logo.png" width="60"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home_prof.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cadastro_treino.php">FICHAS DE TREINO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aulas_agendadas.php">AULAS AGENDADAS</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sair">
                <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                    <a href="index.php" style="color: white; text-decoration: none;">Sair</a>
                </button>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php elseif (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso'] ?></div>
            <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>

        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Aluno</label>
                <select name="aluno_id" class="form-select" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($lista as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nome_completo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">ID Instrutor</label>
                <input type="text" name="instrutor_id" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Início</label>
                <input type="date" name="data_inicio" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Fim</label>
                <input type="date" name="data_fim" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Treino</label>
                <textarea name="descricao" class="form-control" rows="4" required></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit" name="acao">Enviar Dados</button>
            </div>
        </form>
    </main>

    <footer>
        <small>Power House Academia &copy; <?= date('Y'); ?></small>
    </footer>
</body>

</html>