<?php
session_start();

//Se o usuário não existir, redirecionar o acesso à página index
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once ('db_class.php');

function gerarDivSeguidores() {
    $id_usuario = $_SESSION['id_usuario'];

    $objDB = new DB();
    $link = $objDB->conecta_mysql();

    $sql = " SELECT u.usuario as seguidores FROM usuarios AS u LEFT JOIN usuarios_seguidores AS us ON (u.id = us.seguindo_id_usuario) WHERE us.id_usuario = $id_usuario ";

    $resultado_id = mysqli_query($link, $sql);

    if ($resultado_id) {

        while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {

            echo '<div class="list-group-item"><a href="#" class="list-group-item-text"><span>' . $registro['seguidores'] . '</span></a></div>';
        }
    } else {
        echo 'Erro ao consultar Seguidores';
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Twitter Clone</title>
        <script type="text/javascript">
            $(document).ready(function () {
                function removerBackdrop() {
                    if ($('.modal-backdrop').length > 1) {
                        var i = 0;
                        while (i < $('.modal-backdrop').length) {
                            if (i > 0) {
                                var div = $('div.modal-backdrop').last();
                                div.remove();
                            }
                            i++;
                        }
                    }
                }
                removerBackdrop();
            });
        </script>
    </head>
    <body>
        <div style="width: auto;">
            <div>
                <div class="panel panel-default">
                    <div class="panel-body"></div>
                </div>
                <div id="seguidores" class="list-group">
                    <?php gerarDivSeguidores(); ?>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>