<?php

$test = TRUE;
if ($_POST) {
    if ($_POST['cpf']) {
        if (!$test) {
            $user_arr = [];
            $mysqli = new mysqli('127.0.0.1', 'phpuser', 'password@123', 'ecomer');
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                exit();
            }
            
            // Perform query
            if ($result = $mysqli->query("SELECT * FROM cupom WHERE cpf = '" . $_POST['cpf'] . "' AND resgatado = 0")) {
                if ($result->num_rows <= 0) {
                    echo json_encode(['message' => 'Desculpe não encontramos um cupom válido em seu nome, Quem sabe da próxima vez.', 'status' => 'error']);
                    exit();
                }
                
                $fetch = [];
                foreach ($result->fetch_assoc() as $res) {
                    $fetch[] = $res;
                }
                if (!empty($fetch)) {
                    echo json_encode(['message' => 'Seu cupom: <strong>' . $fetch[1] . '</strong>', 'cupom' => $fetch[1], 'status' => 'sucesso']);
                    $sql = "UPDATE cupom SET resgatado = '1', dt_resgate = NOW() WHERE id = '" . $fetch[0] . "'";
                    if (!mysqli_query($mysqli, $sql)) {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                    }
                    exit();
                }
                
                // Free result set
                $result->free_result();
            }
            
            $mysqli->close();
        } else {
            $fetch[1] = '123123123123123123';
            echo json_encode(['message' => 'Seu cupom: <strong>' . $fetch[1] . '</strong>', 'cupom' => $fetch[1], 'status' => 'sucesso']);
            exit();
        }
        
    } else {
        echo json_encode(['message' => 'Preencha o CPF corretamente.', 'status' => 'error']);
    }
}
