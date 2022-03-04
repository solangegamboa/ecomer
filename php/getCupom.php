<?php

function url(){
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if($_POST) {
    if($_POST['matricula']) {
        echo 'XXXXXX-XXXXXX-XXXXXX-XXXXX';
    } else {
        echo 'Matrícula não possui cupom disponível.';
    }
}
