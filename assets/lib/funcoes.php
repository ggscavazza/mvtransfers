<?php
    session_start();
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
?>