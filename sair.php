<?php

session_start();

//A função unset elimina do array o índice passado como parâmetro
unset($_SESSION['usuario']);
unset($_SESSION['email']);

echo 'Esperamos você de volta em breve! <br>=)';

header('Location: index.php');