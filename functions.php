<?php
//header('Location: index.html');

require 'conexao.php';
require_once('index.html');



  



if(isset($_POST['submit']))
{
  date_default_timezone_set('America/Sao_Paulo');

    $Nome=$_POST['name'];
    $Id=$_POST['id'];
    $Email=$_POST['email'];
    $Senha=$_POST['senha'];
    $Categoria=$_POST['categoria'];
    $Saldo;
   if($Categoria=='Empresa'){
    $Saldo=150000;
   }else{
    $Saldo=15000;
   }

    

//$query->query("SELECT ID FROM comum WHERE ID=$Id", $conn);
$result = $conn->query("SELECT * FROM comum WHERE ID=$Id" );
$result2=$conn->query("SELECT * FROM comum WHERE Email='$Email' OR ID=$Id " );
  if (mysqli_num_rows($result2) >0)
  {
      

      echo '<script type="text/javascript">'
      . '$( document ).ready(function() {'
      . '$("#CadastroModal").modal("show");'
      .' $("#Miranda").html("Esse Cadastro já existe");'
      . '});'
      . '</script>';
    
      



  }

  else
  {
    
    $sql = "INSERT INTO comum (ID, Completo, Email,Senha,Saldo,Categoria)
    VALUES ('$Id', '$Nome', '$Email','$Senha', '$Saldo','$Categoria' )";
    
    if ($conn->query($sql) === TRUE) {
      
      echo '<script type="text/javascript">'
      . '$( document ).ready(function() {'
      . '$("#CadastroModal").modal("show");'
      .' $("#Miranda").html("Cadastrado Com sucesso");'
      . '});'
      . '</script>';
    

      

      
   
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    



  }

}

if(isset($_POST['enviar']))
{

   
    

    $Eid=$_POST['Eid'];
    $Eid2=$_POST['Eid2'];
    $Valor=$_POST['Evalor'];
    
    
    $resultado = $conn->query("SELECT * FROM comum where ID = $Eid AND Categoria= 'Pessoa' AND Saldo >'$Valor' " );
    $resultado2 = $conn->query("SELECT * FROM comum where ID =$Eid2 ");
    if (mysqli_num_rows($resultado) >0)
    {

    


    if (mysqli_num_rows($resultado2) >0)
    {
   
      exec('php mail.php');

      

$sql4="UPDATE comum SET  Saldo = CASE ID WHEN  $Eid  THEN Saldo-'$Valor' WHEN $Eid2 THEN Saldo +'$Valor' END WHERE  ID IN ($Eid,  $Eid2)";
$sql5 = " INSERT INTO envios ( Enviador,Recebedor,Valor,Data)
VALUES (' $Eid', '$Eid2','$Valor', Now())";
    



    if ($conn->query($sql4) == TRUE) {

      echo '<script type="text/javascript">'
  . '$( document ).ready(function() {'
  . '$("#exampleModal").modal("show");'
  . '});'
  . '</script>';

    }

if ($conn->query($sql5) == TRUE) {
        
  echo '<script type="text/javascript">'
  . '$( document ).ready(function() {'
  . '$("#exampleModal").modal("show");'
  . '});'
  . '</script>';








} else {
  echo "Ocorreu um erro ao atualizar: " . $conn->error;
}

}
else{
 
  echo '<script type="text/javascript">'
  . '$( document ).ready(function() {'
  . '$("#ModalI").modal("show");'
  . '});'
  . '</script>';



}



    }

    
    
    else {
     
      
      echo '<script type="text/javascript">'
      . '$( document ).ready(function() {'
      . '$("#ModalI").modal("show");'
      . '});'
      . '</script>';
    

    }

    
   


    
    


}



?>