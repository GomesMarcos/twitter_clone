<?php
$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

$mensagen = "<p style='color:#FF0000;'>";
switch ($erro) {
    case '1':

        break;

    case '2':
        $mensagem .= "já cadastrado";

        break;

    case '3':
        $mensagem .= "já cadastrado";

        break;

    case '4':
        $mensagem .= "já cadastrado";

        break;
}

$mensagem .= "</p>";

//echo '<pre>' . print_r($mensagem, true) . '</pre>';die;
        
?>
<!DOCTYPE HTML>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">

        <title>Twitter clone</title>

        <!-- jquery - link cdn -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

        <!-- bootstrap - link cdn -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    </head>

    <body>

        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="imagens/icone_twitter.png" />
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Voltar para Home</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>


        <div class="container">

            <br /><br />

            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3>Inscreva-se já.</h3>
                <form method="post" action="registra_usuario.php" id="formCadastrarse">
                    <div class="form-group">
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required="requiored">
                        <?php if ($erro == 2 || $erro == 4) echo "<p style='color:#FF0000;'>Usuário " . $mensagem . "</p>"; ?>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="requiored">
                        <?php if ($erro == 3 || $erro == 4) echo "<p style='color:#FF0000;'>E-mail " . $mensagem . "</p>"; ?>

                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="requiored">
                    </div>

                    <button type="submit" class="btn btn-primary form-control">Inscreva-se</button>
                </form>
            </div>
            <div class="col-md-4"></div>

            <div class="clearfix"></div>
            <br />
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>

        </div>


    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>
