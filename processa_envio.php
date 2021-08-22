<?php 

    require "./Bibliotecas/PHPMailer/Exception.php";
    require "./Bibliotecas/PHPMailer/OAuth.php";
    require "./Bibliotecas/PHPMailer/PHPMailer.php";
    require "./Bibliotecas/PHPMailer/POP3.php";
    require "./Bibliotecas/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    //print_r($_POST);

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo , $valor) {
         $this->$atributo = $valor;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;
        }
    }

    $mensagem = new Mensagem();

    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    /*echo '<pre>';
    print_r($mensagem);
    echo '<\pre>';*/

    if(!$mensagem->mensagemValida()){
        echo 'mensagem não é valida';
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'soparatestes242@gmail.com';                     //SMTP username
        $mail->Password   = '********';                               //SMTP password
        $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('soparatestes242@gmail.com', 'Remetente');
        $mail->addAddress('soparatestes242@gmail.com', 'Destinatario');     //Add a recipient               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Oi, Eu sou o assunto';
        $mail->Body    = 'Oi, Eu sou o conteudo do <b>e-mail!</b>';
        $mail->AltBody = 'Oi, Eu sou o conteudo do e-mail!';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


?>