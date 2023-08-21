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
                $updt = "UPDATE {$table_prefix}_viagens SET status='1' WHERE id='{$id_viagem}'}";
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
            $sel = "SELECT id FROM {$table_prefix}_viagens WHERE id='{$id_viagem}'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);

            if($num > 0){
                $updt = "UPDATE {$table_prefix}_viagens SET status='0' WHERE id='{$id_viagem}'}";
                mysqli_query($conn, $updt);

                return true;
            }else{
                return false;
            }
        }
    }
?>