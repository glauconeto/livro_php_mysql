<?php

$mysqli = mysqli_connect(DB_SERVIDOR, DB_USUARIO, DB_SENHA, DB_BANCO);

if ($mysqli->connect_errno) {
    echo "Problemas para conectar no banco. Verifique os dados!";
    echo mysqli_connect_error();
    die();
}