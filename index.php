<?php
session_start();
require 'conexao.php';

if (isset($_POST['acao'])) {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nome_usuario = :nome_usuario AND senha = :senha");
    $sql->bindValue(":nome_usuario", $nome_usuario);
    $sql->bindValue(":senha", $senha);

    $sql->execute();

    if ($sql->rowCount() > 0) {
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome_usuario'] = $user['nome_usuario'];
        $_SESSION['user_perfil'] = $user['perfil'];

        if ($user['perfil'] === 'Administrador') {
            header("Location: home_admin.php");
            exit();
        } elseif ($user['perfil'] === 'Instrutor') {
            header("Location: home_prof.php");
            exit();
        } elseif ($user['perfil'] === 'Aluno') {
            header("Location: home_aluno.php");
            exit();
        } 
    } else {
        echo '<div class="alert alert-danger">Usuário ou senha inválidos!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="imagens/logo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        * {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: LightSkyBlue;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        div {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 40px 60px;
            border-radius: 15px;
            text-align: center;
            color: white;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            border: none;
            outline: none;
            font-size: 14px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 12px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            background-color: dodgerblue;
            color: white;
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
            color: white;
        }
    </style>
</head>

<body>
    <div>
        <img src="imagens/logo.png" width="150" alt="Logo">
        <h1>LOGIN</h1>
        <form method="post">
            <input type="text" name="nome_usuario" placeholder="Nome de Usuário" required>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <span class="toggle-password" id="toggle-password"></span>
            <input type="submit" name="acao" value="Entrar">
        </form>
    </div>
    <script>
        const senhaInput = document.getElementById('senha');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('mousedown', () => {
            senhaInput.type = 'text';
        });

        togglePassword.addEventListener('mouseup', () => {
            senhaInput.type = 'password';
        });

        togglePassword.addEventListener('mouseout', () => {
            senhaInput.type = 'password';
        });
    </script>
</body>

</html>
