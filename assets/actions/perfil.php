<?php
    include ('../lib/funcoes.php');

    if($_REQUEST['atualizar']){
        $id_perfil = addslashes($_REQUEST['id_perfil']);
        $dados['nome'] = addslashes($_REQUEST['nome']);
        $dados['tel'] = addslashes($_REQUEST['tel']);
        $dados['email'] = addslashes($_REQUEST['email']);

        if($_REQUEST['senha'] != "" && !is_null($_REQUEST['senha'])){
            if($_REQUEST['senha2'] != "" && !is_null($_REQUEST['senha2'])){
                if($_REQUEST['senha'] == $_REQUEST['senha2']){
                    $dados['senha'] = addslashes($_REQUEST['senha']);
                    $dados['senha2'] = addslashes($_REQUEST['senha2']);
                }else{
                    header('location: ../../perfil.php?e=1');
                    exit();
                }
            }else{
                header('location: ../../perfil.php?e=2');
                exit();
            }
        }

        $atualizar = atualizaPerfil($id_perfil, $dados);

        if($atualizar === true){
            header('location: ../../perfil.php?a=1');
            exit();
        }else{
            header('location: ../../perfil.php?e=3');
            exit();
        }
    }
