<?php
    include ('../lib/funcoes.php');

    if($_REQUEST['aceitar']){
        $id_viagem = addslashes($_REQUEST['id_viagem']);
        $euros = addslashes($_REQUEST['valor_correto']);

        $aceitar = aceitaViagem($id_viagem, $euros);

        if ($aceitar === true) {
            header('location: ../../home.php?a=1');
            exit();
        } else {
            header('location: ../../home.php?e=1');
            exit();
        }
    }

    if($_REQUEST['recusar']){
        $id_viagem = addslashes($_REQUEST['id_viagem']);
        
        $recusar = recusaViagem($id_viagem);

        if($recusar === true){
            header('location: ../../home.php?r=1');
            exit();
        }else{
            header('location: ../../home.php?e=2');
            exit();
        }
    }
