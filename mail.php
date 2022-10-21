<?php
require 'conexao.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


$sql2="SELECT * FROM comum,envios where comum.ID = envios.Recebedor";
$result = $conn->query($sql2);



if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $ID=$row["ID"];
   
    $nome=$row["Completo"];
    $Email= $row["Email"];
    $Recebedor=$row["Recebedor"];
    $Enviador=$row["Enviador"];
    $Data=$row["Data"];
    $Valor=$row["Valor"];

    echo 'nome é :'.$nome ;

  }
} else {
  echo "0 results";
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '<Your-Email>';                     //SMTP username
    $mail->Password   = '<yourpass>';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('joaoecarol39@gmail.com', 'PicPay');
    $mail->addAddress( $Email, 'Joe User');     //Add a recipient
    $mail->addAddress( $Email);               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
  

    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = ' Pagamento Recebido!!!';
    $mail->Body    = '
    
    
    <html>
<head>
<style>

    body{
        background-color: white;
       
    }

    
   
   


    form{
        margin-top: 20px;
        text-align: center;
        border-style: groove;
       background-color: dimgray;
       width: 720px;    
        border-color: black;
        margin-left: 4%;
    
    
    }

.titulo{
    color: black;
    background-color: brown;
    border-bottom: 11px 11px;
    margin-top: -27px;
}
.corpo{
    color: white;

}

</style>


</head>
<body>

    <form >
    <div id="titulo" class="titulo">
        <h1> estou aqui </h1>    
    </div>
     
    <div id="corpo" class="corpo">

       <h2> Obrigado pela sua colaboração <b>'.$nome.' </b>! Nós apenas nos tornamos uma empresa que trabalha com amor, porque temos clientes como você ao nosso lado, o valor recebido foi de:R$ '.$Valor.'
        O nosso compromisso é com você! Prezamos pela entrega do trabalho com qualidade e sentimos muita gratidão pela sua confiança em nossa empresa.
        Gostaríamos apenas de dizer obrigado por fazer parte da nossa família. Somos muito gratos, não estaríamos aqui sem clientes fiéis como você.
        A confiança depositada em nossos produtos e serviços é o melhor reconhecimento que poderíamos receber. Muito obrigado pela confiança!
       </h2>

    </div>


    </form>




</body>


</html>
    
    
    
    
    '.$Data;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
