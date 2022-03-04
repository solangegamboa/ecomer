<?php

function dbConn($DBname) {
    $dbconn = new mysqli('127.0.0.1', 'root', 'Dm$M20@zBx50ZN', 'ecomer');
    mysqli_set_charset($dbconn,"UTF8");
    return $dbconn;
}

if($_POST) {
    if($_POST['cpf']) {
        echo 'XXXXXX-XXXXXX-XXXXXX-XXXXX';
    } else {
        echo 'Matrícula não possui cupom disponível.';
    }
}
