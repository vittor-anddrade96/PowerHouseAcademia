<?php
session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $idExcluir = $_POST['excluir_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM instrutores WHERE id = :id");
        $stmt->bindParam(':id', $idExcluir, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['mensagem'] = "Instrutor excluído com sucesso!";
    } catch (PDOException $e) {
        $_SESSION['erro'] = "Erro ao excluir o instrutor: " . $e->getMessage();
    }
    header('Location: instrutores.php');
    exit;
}

try {
    $sql = $pdo->query("SELECT * FROM instrutores");
    $instrutores = $sql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
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
        <?php if (!empty($instrutores)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Instrutor</th>
                            <th>Formação</th>
                            <th>Especializações</th>
                            <th>Horário de Trabalho</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instrutores as $prof): ?>
                            <tr>
                                <td><?= $prof['id']; ?></td>
                                <td><?= $prof['nome_completo']; ?></td>
                                <td><?= $prof['formacao']; ?></td>
                                <td><?= $prof['especializacoes']; ?></td>
                                <td><?= $prof['horario_trabalho']; ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este instrutor?');">
                                        <input type="hidden" name="excluir_id" value="<?= $prof['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        </main>
        <footer>
            <small>Power House Academia &copy; <?= date('Y'); ?></small>
        </footer>
</body>

</html>