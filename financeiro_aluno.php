<?php
session_start();

require 'conexao.php';


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
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: -20px;
        }

        .sair {
            margin: 10px;
        }

        .carousel-inner img {
            width: 100%;
            height: 60vh;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            top: 50%;
            transform: translateY(-50%);
            width: 5%;
            height: 5%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: contain;
            background-repeat: no-repeat;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .carousel-indicators {
            bottom: 10px;
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
                <a class="navbar-brand" href="home_aluno.php"><img id="imagens" src="imagens/logo.png" width="60"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home_aluno.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ficha_treino.php">FICHA DE TREINO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="agend_aula.php">AGENDAMENTO DE AULA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="instrutores_aluno.php">INSTRUTORES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="financeiro_aluno.php">FINANCEIRO</a>
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
        <br>
 
    </header>

    <main>

    </main>

    <footer>
        <small>Power House Academia &copy; <?= date('Y'); ?></small>
    </footer>
</body>

</html>