<?php
class DB{
    
    //host
    private $host = 'localhost';
    
    //usuario
    private $usuario = 'root';
    
    //senha
    private $senha = '';
        
    //banco de dados
    private $dataBase = 'twitter_clone';
    
    public function conecta_mysql(){
        //criar a conexão
        $con = mysqli_connect( $this->host, $this->usuario , $this->senha , $this->dataBase );
        
        //Indicar o charset do banco
        mysqli_set_charset($con , 'utf8');
        
        
//        verifica se houve erro de conexão
        if(mysqli_connect_errno()){
            echo 'Erro ao tentar se conectar com o Banco de Dados MySQL: ' . mysqli_connect_error();
        }
        
        return $con;
    }
}


?>
