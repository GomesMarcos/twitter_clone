<?php

require_once ('db_class.php');

$sql = "SELECT * FROM usuarios";

$objDB = new DB();
$link = $objDB->conecta_mysql();


$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
    
    //mysqli_fetch_array(); retorna apenas 1 registro!!!
    $dados_usuario = array();
    
    while ($linha = mysqli_fetch_array($resultado_id , MYSQLI_ASSOC)) {
        $dados_usuario[] = $linha;
    }
    
    foreach ($dados_usuario as $usuario) {
        echo '<pre>' . print_r($usuario, true) . '</pre>';
    }
    
} else {
    echo "Erro na consulta. Favor entrar em contato com o Admin do Site";
}
