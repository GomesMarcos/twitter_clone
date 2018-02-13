<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once ('db_class.php');

$id_usuario = $_SESSION['id_usuario'];

$objDB = new DB();
$link = $objDB->conecta_mysql();

$sql  = " SELECT DATE_FORMAT(t.dt_inclusao, '%d/%m/%Y às %T') AS dt_inclusao_formatada, t.tweet, u.usuario FROM tweet AS t";
$sql .= " JOIN usuarios AS u ON u.id = t.id_usuario WHERE id_usuario = $id_usuario ORDER BY dt_inclusao DESC  ";

$resultado_id = mysqli_query($link, $sql);

if($resultado_id){
    
    while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
        echo '<a href="#" class="list-group-item">';
            echo '<h4 class="list-group-item-heading">' . $registro['usuario'] . ' <small> - ' . $registro['dt_inclusao_formatada'] . '</small></h4>';
            echo '<p class="list-group-item-text">' . $registro['tweet'] . '</p>';
        echo '</a>';
    }
        
} else {
    echo 'Erro na consulta de mensagens no Banco de Dados';
}
?>
