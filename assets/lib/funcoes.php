<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    include ("conn.php");

    function fazLogin($login=null, $senha=null)
    {
        global $conn;
        global $table_prefix;

        if(!is_null($login)){
            $login = md5($login);
        }else{
            $erro = 1;
        }

        if(!is_null($senha)){
            $senha = md5($senha);
        }else{
            $erro = 1;
        }

        if(!$erro){
            $sel = "SELECT * FROM {$table_prefix}_usuarios WHERE login='{$login}' AND senha='{$senha}' AND status='1'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $lnh = mysqli_fetch_array($res);

                $_SESSION['nome'] = $lnh['nome'];
                $_SESSION['token'] = $lnh['token'];
                $_SESSION['tipo'] = $lnh['tipo'];

                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function buscaViagens($status=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT * FROM {$table_prefix}_viagens WHERE status='$status' ORDER BY id ASC";
        $res = mysqli_query($conn, $sel);

        return $res;
    }

    function buscaNome($token=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT nome FROM {$table_prefix}_usuarios WHERE token='$token'";
        $res = mysqli_query($conn, $sel);
        $lnh = mysqli_fetch_array($res);

        $retorno = $lnh['nome'];

        return $retorno;
    }

    function buscaEmail($token=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT email FROM {$table_prefix}_usuarios WHERE token='$token'";
        $res = mysqli_query($conn, $sel);
        $lnh = mysqli_fetch_array($res);

        $retorno = $lnh['email'];

        return $retorno;
    }

    function buscaTelefone($token=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT telefone FROM {$table_prefix}_usuarios WHERE token='$token'";
        $res = mysqli_query($conn, $sel);
        $lnh = mysqli_fetch_array($res);

        $retorno = $lnh['telefone'];

        return $retorno;
    }

    function aceitaViagem($id_viagem=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_viagem) || $id_viagem == ""){
            return false;
        }else{
            $sel = "SELECT id FROM {$table_prefix}_viagens WHERE id='{$id_viagem}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_viagens SET status=1 WHERE id='{$id_viagem}'";
                mysqli_query($conn, $updt);

                return true;
            }else{
                return false;
            }
        }
    }

    function recusaViagem($id_viagem=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_viagem) || $id_viagem == ""){
            return false;
        }else{
            $sel = "SELECT * FROM {$table_prefix}_viagens WHERE id='{$id_viagem}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_viagens SET status=0 WHERE id='{$id_viagem}'";
                mysqli_query($conn, $updt);

                return true;
            }else{
                return false;
            }
        }
    }

    function buscaParceiros($status=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT * FROM {$table_prefix}_parceiros WHERE status='$status' ORDER BY id ASC";
        $res = mysqli_query($conn, $sel);

        return $res;
    }

    function aceitaParceiro($id_parceiro=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_parceiro) || $id_parceiro == ""){
            return false;
        }else{
            $sel = "SELECT id FROM {$table_prefix}_parceiros WHERE id='{$id_parceiro}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_parceiros SET status=1 WHERE id='{$id_parceiro}'";
                mysqli_query($conn, $updt);

                $lnh = mysqli_fetch_array($res);
                $nome = $lnh['nome'];
                $email = $lnh['email'];
                $tel = $lnh['telefone'];
                $token = $lnh['token'];

                //dados usuário
                $login = md5($email);
                $senha_random = randomSenha(8);
                $senha = md5($senha_random);

                $ver = "SELECT * FROM {$table_prefix}_usuarios WHERE (email='{$email}' OR token='{$token}') AND status='1'";
                $resVer = mysqli_query($conn, $ver);
                $numVer = mysqli_num_rows($resVer);

                if($numVer <= 0) {
                    $sql = "INSERT INTO {$table_prefix}_usuarios (nome, telefone, email, login, senha, token, tipo, status) VALUES ('{$nome}', '{$tel}', '{$email}', '{$login}', '{$senha}', '{$token}', 4, 1)";
                    mysqli_query($conn, $sql);

                    $retorno_usu = 1;
                } else {
                    $retorno_usu = 2;
                }

                if($retorno_usu == 1){
                    $assunto = "aceite_parceiro";
                    disparaEmail($nome, $senha_random, $assunto, $email);
                }

                return true;                
            }else{
                return false;
            }
        }
    }

    function recusaParceiro($id_parceiro=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_parceiro) || $id_parceiro == ""){
            return false;
        }else{
            $sel = "SELECT * FROM {$table_prefix}_parceiros WHERE id='{$id_parceiro}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_parceiros SET status=0 WHERE id='{$id_parceiro}'";
                mysqli_query($conn, $updt);

                $lnh = mysqli_fetch_array($res);
                $nome = $lnh['nome'];
                $email = $lnh['email'];
                $token = $lnh['token'];

                $ver = "SELECT * FROM {$table_prefix}_usuarios WHERE (email='{$email}' OR token='{$token}') AND status='1'";
                $resVer = mysqli_query($conn, $ver);
                $numVer = mysqli_num_rows($resVer);

                if($numVer > 0) {
                    $sql = "UPDATE {$table_prefix}_usuarios SET status=0 WHERE token='{$token}'";
                    mysqli_query($conn, $sql);

                    $retorno_usu = 1;
                } else {
                    $retorno_usu = 1;
                }

                if($retorno_usu == 1){
                    $assunto = "recusa_parceiro";
                    disparaEmail($nome, null, $assunto, $email);
                }

                return true;
            }else{
                return false;
            }
        }
    }

    function buscaUsuarios($status=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT * FROM {$table_prefix}_usuarios WHERE status='$status' ORDER BY id ASC";
        $res = mysqli_query($conn, $sel);

        return $res;
    }

    function buscaTipoUsuario($id_tipo=null)
    {
        global $conn;
        global $table_prefix;

        $sel = "SELECT nome FROM {$table_prefix}_tipos_usuarios WHERE id='{$id_tipo}'";
        $res = mysqli_query($conn, $sel);
        $lnh = mysqli_fetch_array($res);

        $retorno = $lnh['nome'];

        return $retorno;
    }

    function ativaUsuario($id_usuario=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_usuario) || $id_usuario == ""){
            return false;
        }else{
            $sel = "SELECT id FROM {$table_prefix}_usuarios WHERE id='{$id_usuario}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_usuarios SET status=1 WHERE id='{$id_usuario}'";
                mysqli_query($conn, $updt);

                return true;
            }else{
                return false;
            }
        }
    }

    function inativaUsuario($id_usuario=null)
    {
        global $conn;
        global $table_prefix;

        if(is_null($id_usuario) || $id_usuario == ""){
            return false;
        }else{
            $sel = "SELECT * FROM {$table_prefix}_usuarios WHERE id='{$id_usuario}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_usuarios SET status=0 WHERE id='{$id_usuario}'";
                mysqli_query($conn, $updt);

                return true;
            }else{
                return false;
            }
        }
    }

    function disparaEmail($nome=null, $senha_random=null, $assunto=null, $email=null)
    {       
        $data_envio = date('d/m/Y');
        $hora_envio = date('H:i:s');

        if($assunto == "aceite_parceiro") {    
            $assunto = "Retorno sobre parceria - MV Transfers";

            $arquivo = "<style type='text/css'>
                body {
                    margin:0px;
                    font-family:Verdane;
                    font-size:20px;
                    color: #202020;
                }
                </style>

                <html>
                <head>
                <meta charset='UTF-8'>
                </head>
                <p>Olá {$nome},</p><br>
                <p>Parabéns! Seu pedido de parceria foi aceito.</p>
                <p>Foi criada uma conta automáticamente para nosso sitema, os dados de acesso estão abaixo:</p><br>
                <p>Login: <i><b>seu email</b></i></p>
                <p>Senha provisória: <i><b>{$senha_random}</b></i></p><br>
                <small>Aconselhamos alterar sua senha após o primeiro acesso.</small><br>
                <p>Seu acesso já está liberado basta <a href='https://mvtransfers.com/sistema/' target='_blank'>clicar aqui</a>.</p><br><br>
                <p>Atenciosamente,<br>Equipe MVTransfers</p><br>            
                <p style='margin-top: 2%;'>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></p>
            </html>";
        }else if($assunto == "recusa_parceiro") {
            $assunto = "Retorno sobre parceria - MV Transfers";

            $arquivo = "<style type='text/css'>
                body {
                    margin:0px;
                    font-family:Verdane;
                    font-size:20px;
                    color: #202020;
                }
                </style>

                <html>
                <head>
                <meta charset='UTF-8'>
                </head>
                <p>Olá {$nome},</p><br>
                <p>Que pena! Seu pedido de parceria foi recusado.</p>
                <p>Caso ainda tenha alguma dúvida entre em contato conosco pelo email ou telefone que disponibilizamos no rodapé do nosso site.</p><br><br>
                <p>Atenciosamente,<br>Equipe MVTransfers</p><br>            
                <p style='margin-top: 2%;'>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></p>
            </html>";
        }    

        /* DISPARA EMAIL PARA O SOLICITANTE */
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP(); //Send using SMTP
        $mail->Host       = 'mail.mvtransfers.com'; //Set the SMTP server to send through
        $mail->SMTPAuth   = true; //Enable SMTP authentication
        $mail->Username   = 'contact@mvtransfers.com'; //SMTP username
        $mail->Password   = 'contact@2023@mvtransfers'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port       = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('contact@mvtransfers.com', 'MV Transfers - Contact');
        $mail->addAddress($email, $nome); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $assunto;
        $mail->Body    = $arquivo;

        $mail->send();
        /* FIM DISPARA EMAIL PARA O SOLICITANTE */
    }

    function randomSenha ($length)
    {
        $str = random_bytes($length);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        $str = substr($str, 0, $length);

        return $str;
    }
?>