<?php

class cadastro_funcionario extends medcontrol_db{

    protected function set_usuario($nomeCompleto, $password, $email, $sexo, $idade, $cargo, $cpf) // Método que insere dados de um cadastro no banco
    {
        $comandosql = $this->connect()->prepare('INSERT INTO funcionario (nome, senha, email, sexo, idade, cargo, CPF) VALUES (?, ?, ?, ?, ?, ?, ?);');
        
        if(!$comandosql) {
         $errorMessage = implode(", ", $this->connect()->errorInfo());
         die("Erro ao preparar a declaração: " . $errorMessage);
     }
 
        $cripto_senha = password_hash($password, PASSWORD_DEFAULT); //Criptografa senha inserida
           
        if(!$comandosql->execute(array($nomeCompleto, $cripto_senha, $email, $sexo, $idade, $cargo, $cpf))) //executa instruções
        {
           $comandosql = null;
           header("location: ../cadastre.php?error=comandosqlfalhouacima");
           exit();
        }

        $checar_resultado;
   
        if($comandosql->rowCount() > 0) //verifica se inserção funcionou
        
        {
         $checar_resultado = false;
         header("location: ../cadastre.php?error=comandosqlfalhou");
         return $checar_resultado;
   
        }
        else{
           $checar_resultado = true;
           header("location: ../../cadastre.php?error=none");
           return $checar_resultado;
        }
   
        
       }


    protected function checar_usuario($nomeCompleto, $email) // Método que checa se dados de funcionário existem no banco
    {
     $comandosql = $this->connect()->prepare('SELECT nome FROM funcionario WHERE nome = ? OR email = ?;'); 
        
     if(!$comandosql->execute(array($nomeCompleto,$email))){
        $comandosql = null;
        header("location: ../cadastre.php?error=zxcomandosqlfalhou");
        exit();
     }
     $checar_resultado;

     if($comandosql->rowCount() > 0) //verifica se existe funcionario com esse nome
     {

        $checar_resultado = false;
        header("location: ../cadastre.php?error=zzcomandosqlfalhou");
        return $checar_resultado;

     }
     else{
        $checar_resultado = true;
        header("location: ../cadastre.php?error=none");
        return $checar_resultado;
     }

     
    }
}


