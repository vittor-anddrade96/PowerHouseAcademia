<?php
session_start();
require 'conexao.php';

try {
  $sql = $pdo->query("SELECT * FROM planos");
  $planos = $sql->fetchAll(PDO::FETCH_ASSOC);
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
      align-items: center;
    }

    .planos-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      align-items: flex-start;
    }

    .plano-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
      padding: 20px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .plano-card h4 {
      font-size: 1.5rem;
      color: DodgerBlue;
    }

    .plano-card .valor {
      font-size: 2rem;
      font-weight: bold;
      margin: 10px 0;
    }

    .beneficios {
      list-style: disc;
      padding-left: 20px;
      text-align: left;
      margin-top: 10px;
    }

    .beneficios li {
      margin-bottom: 5px;
      font-size: 0.9rem;
      color: #333;
    }

    .plano-card .btn {
      margin-top: 20px;
      background-color: DodgerBlue;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      width: 100%;
    }

    .plano-card .btn:hover {
      background-color: RoyalBlue;
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
        <a class="navbar-brand" href="home_admin.php"><img id="imagens" src="imagens/logo.png" width="60"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="home_admin.php">HOME</a></li>
            <li class="nav-item"><a class="nav-link" href="cad_aluno.php">CADASTRO DE ALUNOS</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">INSTRUTORES</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="cad_prof.php">CADASTRO DE INSTRUTORES</a></li>
                <li><a class="dropdown-item" href="instrutores.php">QUADRO DE COLABORADORES</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="financeiro.php">FINANCEIRO</a></li>
            <li class="nav-item"><a class="nav-link active" href="planos.php">PLANOS</a></li>
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
    <div class="planos-container">
      <?php if ($planos): ?>
        <?php foreach ($planos as $plan): ?>
          <div class="plano-card">
            <h4><?= $plan['nome_plano']; ?></h4>
            <div class="valor">R$ <?= number_format($plan['valor_mensal'], 2, ',', '.'); ?> <small>/mês</small></div>
            <ul class="beneficios">
              <?php
              $beneficios = explode(',', $plan['beneficios']);
              foreach ($beneficios as $beneficio):
              ?>
                <li><?= trim($beneficio); ?></li>
              <?php endforeach; ?>
            </ul>
            <a href="cad_aluno.php" class="btn">Matricule-se</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Nenhum plano encontrado.</p>
      <?php endif; ?>
    </div>
  </main>
  <footer>
    <small>Power House Academia &copy; <?= date('Y'); ?></small>
  </footer>
</body>

</html>