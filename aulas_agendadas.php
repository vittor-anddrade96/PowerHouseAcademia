<?php
session_start();

require 'conexao.php';

// Consulta para buscar agendamentos com informações relacionadas
$sql = $pdo->prepare(
    "SELECT agendamentos.id, alunos.nome_completo AS aluno, aulas.nome_aula AS aula, agendamentos.data_agendamento 
     FROM agendamentos 
     JOIN alunos ON agendamentos.aluno_id = alunos.id 
     JOIN aulas ON agendamentos.aula_id = aulas.id"
);
$sql->execute();
$agendamentos = $sql->fetchAll(PDO::FETCH_ASSOC);
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

        * {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: LightSkyBlue;
        }

        .navbar {
            margin-bottom: 0;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.25);
            background-color: whitesmoke;
            border-radius: 2px;
        }

        .sair {
            margin: 10px;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: -20px;
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
                <a class="navbar-brand" href="home_prof.php"><img id="imagens" src="imagens/logo.png" width="60"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home_prof.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro_treino.php">FICHAS DE TREINO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="aulas_agendadas.php">AULAS AGENDADAS</a>
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

    <main>
        <?php if (!empty($agendamentos)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>Aula</th>
                            <th>Data de Agendamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agendamentos as $agendamento): ?>
                            <tr>
                                <td><?= $agendamento['id']; ?></td>
                                <td><?= $agendamento['aluno']; ?></td>
                                <td><?= $agendamento['aula']; ?></td>
                                <td><?= $agendamento['data_agendamento']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Nenhum agendamento encontrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <small>Power House Academia &copy; <?= date('Y'); ?></small>
    </footer>
</body>

</html>
