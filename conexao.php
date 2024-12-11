<?php

$pdo = new PDO('mysql:host=localhost:3306;dbname=dbacademia', 'root', 'Cimatec');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);