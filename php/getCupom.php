<?php

if ($_POST) {
    if ($_POST['cpf']) {
        $user_arr = [];
        $mysqli = new mysqli('127.0.0.1', 'root', 'Dm$M20@zBx50ZN', 'ecomer');
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }
        
        // Perform query
        if ($result = $mysqli->query("SELECT * FROM cupom WHERE cpf = '" . $_POST['cpf'] . "' AND resgatado = 0")) {
            if ($result->num_rows <= 0) {
                echo json_encode(['message' => 'Desculpe não encontramos o seu nome na nossa lista, Quem sabe da próxima vez.', 'status' => 'error']);
                exit();
            }
            
            $fetch = [];
            foreach ($result->fetch_assoc() as $res) {
                $fetch[] = $res;
            }
            if (!empty($fetch)) {
                echo json_encode(['message' => $fetch[1], 'status' => 'sucesso']);
                $mysqli->query("UPDATE cupom SET resgatado = 1 AND dt_resgate = NOW() WHERE cupom = '" . $fetch[1] . "'");
                exit();
            }
            
            // Free result set
            $result->free_result();
        }
        
        $mysqli->close();
    } else {
        echo json_encode(['message' => 'Desculpe não encontramos o seu nome na nossa lista, Quem sabe da próxima vez.', 'status' => 'error']);
    }
}
