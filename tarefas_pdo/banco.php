<?php

try {
    $pdo = new PDO(DB_DSN, DB_USUARIO, DB_SENHA);
} catch (PDOException $e) {
    echo 'Falha na conexão com o banco de dados: ' . $e->getMessage();
    die();
}