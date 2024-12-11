<?php
session_start();

require 'conexao.php';

$sql = $pdo->prepare("SELECT * FROM alunos");
$sql->execute();
$lista = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $pdo->prepare("SELECT * FROM aulas");
$sql->execute();
$listaa = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['acao'])) {
  $aluno_id = trim($_POST['aluno_id']);
  $aula_id = trim($_POST['aula_id']);
  $data_agendamento = trim($_POST['data_agendamento']);
  $situacao = trim($_POST['situacao']);

  if (empty($aluno_id)) {
    $erro = 'O aluno não pode ficar vazio!';
  } elseif (empty($aula_id)) {
    $erro = 'A aula não pode ficar vazia!';
  } elseif (empty($data_agendamento)) {
    $erro = 'A data precisa ser selecionada!';
  } else {
    try {
      $pdo->beginTransaction();

      $sql = $pdo->prepare("INSERT INTO agendamentos (aluno_id, aula_id, data_agendamento, situacao) VALUES (:aluno_id, :aula_id, :data_agendamento, :situacao)");
      $sql->bindValue(':aluno_id', $aluno_id);
      $sql->bindValue(':aula_id', $aula_id);
      $sql->bindValue(':data_agendamento', $data_agendamento);
      $sql->bindValue(':situacao', $situacao);
      $sql->execute();

      $pdo->commit();
      $_SESSION['mensagem_sucesso'] = 'Agendamento confirmado';
    } catch (Exception $e) {
      $pdo->rollBack();
      $erro = 'Erro ao fazer agendamento: ' . $e->getMessage();
    }
  }
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
              <a class="nav-link active" href="agend_aula.php">AGENDAMENTO DE AULA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="instrutores_aluno.php">INSTRUTORES</a>
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
  <main class="container py-4">
    <?php if (!empty($erro)): ?>
      <div class="alert alert-danger"><?= $erro ?></div>
    <?php elseif (!empty($_SESSION['mensagem_sucesso'])): ?>
      <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso'] ?></div>
      <?php unset($_SESSION['mensagem_sucesso']); ?>
    <?php endif; ?>

    <h2 class="text-center mb-4" style="font-weight: bold;">Agendamento de Aulas</h2>
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
        <label class="form-label">Aula</label>
        <select name="aula_id" class="form-select" required>
          <option value="">Selecione a Aula</option>
          <?php foreach ($listaa as $b): ?>
            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nome_aula']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Data Agendamento</label>
        <input type="date" name="data_agendamento" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Status do Agendamento</label>
        <select name="situacao" class="form-select" required>
          <option>Pendente</option>
            <option>Confirmado</option>
            <option>Cancelado</option>
        </select>
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