<?php
session_start();
require 'conexao.php';

try {
  $sql = $pdo->query("SELECT * FROM treinos");
  $treinos = $sql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Erro ao buscar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Power House Academia</title>
  <link rel="icon" href="imagens/logo.png">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: LightSkyBlue;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
      padding: 20px;
      display: flex;
      justify-content: center;
    }

    .sair {
      margin: 10px;
    }

    .table {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
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
              <a class="nav-link active" href="ficha_treino.php">FICHA DE TREINO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="agend_aula.php">AGENDAMENTO DE AULA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="">INSTRUTORES</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="">FINANCEIRO</a>
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
    <div class="container">
      <h2 class="text-center mb-4" style="font-weight: bold;">Treinos Disponíveis</h2>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center">TREINO</th>
              <th class="text-center">TIPO TREINO</th>
              <th class="text-center">PDF</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($treinos): ?>
              <?php foreach ($treinos as $trein): ?>
                <tr>
                  <td class="text-center"><?= htmlspecialchars($trein['id']); ?></td>
                  <td class="text-center"><?= htmlspecialchars($trein['descricao']); ?></td>
                  <td class="text-center">
                    <a href="pdfs/treino_<?= htmlspecialchars($trein['id']); ?>.pdf" target="_blank" class="btn btn-primary">
                      Abrir PDF
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="2" class="text-center">Nenhum treino encontrado.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>
  <footer>
    <small>Power House Academia &copy; <?= date('Y'); ?></small>
  </footer>
</body>

</html>