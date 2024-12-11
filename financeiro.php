<?php
session_start();

require 'conexao.php';


try {
    $sql = $pdo->query("SELECT p.id, p.data_vencimento, p.valor, p.status_pagamento, p.criado_em, a.nome_completo AS aluno_nome FROM Pagamentos p JOIN Alunos a ON p.aluno_id = a.id ORDER BY p.data_vencimento DESC");
    $pagamentos = $sql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
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
            text-align: center;
            display: flex;
            gap: 20px;
            justify-content: center;
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

        .status-pago {
            color: green;
            font-weight: bold;
        }

        .status-pendente {
            color: orange;
            font-weight: bold;
        }

        .status-atrasado {
            color: red;
            font-weight: bold;
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
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                INSTRUTORES
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="cad_prof.php">CADASTRO DE INSTRUTORES</a></li>
                                <li><a class="dropdown-item" href="instrutores.php">QUADRO DE COLABORADORES</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="financeiro.php">FINANCEIRO</a>
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
        <div class="container">
            <h1 class="my-4">Gerenciamento de Pagamentos</h1>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>Data de Vencimento</th>
                            <th>Valor (R$)</th>
                            <th>Status</th>
                            <th>Data de Criação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pagamentos)): ?>
                            <?php foreach ($pagamentos as $pagamento): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pagamento['id']) ?></td>
                                    <td><?= htmlspecialchars($pagamento['aluno_nome']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($pagamento['data_vencimento'])) ?></td>
                                    <td><?= number_format($pagamento['valor'], 2, ',', '.') ?></td>
                                    <td class="status-<?= strtolower($pagamento['status_pagamento']) ?>">
                                        <?= htmlspecialchars($pagamento['status_pagamento']) ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pagamento['criado_em'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Nenhum pagamento encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
<footer>
    <small>Power House Academia &copy; <?= date('Y'); ?></small>
</footer>

</html>