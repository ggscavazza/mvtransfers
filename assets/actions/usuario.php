<?php
    include ('../lib/funcoes.php');

    if($_REQUEST['aceitar']){
        $id_usuario = addslashes($_REQUEST['id_usuario']);

        $aceitar = ativaUsuario($id_usuario);

        if($aceitar === true){
            header('location: ../../usuarios.php?a=1');
            exit();
        }else{
            header('location: ../../usuarios.php?e=1');
            exit();
        }
    }

    if($_REQUEST['recusar']){
        $id_usuario = addslashes($_REQUEST['id_usuario']);
        
        $recusar = inativaUsuario($id_usuario);

        if($recusar === true){
            header('location: ../../usuarios.php?r=1');
            exit();
        }else{
            header('location: ../../usuarios.php?e=2');
            exit();
        }
    }
