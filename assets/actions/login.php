<?php
    include ('../lib/funcoes.php');
    
    if($_REQUEST['entrar']){
        $login = addslashes($_REQUEST['login']);
        $senha = addslashes($_REQUEST['senha']);

        if($login == "" || $senha == ""){
            $erro = 1;
            header('location: ../../index.php?e=1');
        }

        if(!$erro){
            $logar = fazLogin($login,$senha);

            if($logar === true){
                header('location: ../../home.php');
                exit();
            }else{
                header('location: ../../index.php?e=2');
                exit();
            }
        }
    }else{
        header('location: ../../index.php');
        exit();
    }
