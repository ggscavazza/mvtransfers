<?php
    include ('../lib/funcoes.php');

    if($_REQUEST['aceitar']){
        $id_parceiro = addslashes($_REQUEST['id_parceiro']);

        $aceitar = aceitaParceiro($id_parceiro);

        if($aceitar === true){
            header('location: ../../parceiros.php?a=1');
            exit();
        }else{
            header('location: ../../parceiros.php?e=1');
            exit();
        }
    }

    if($_REQUEST['recusar']){
        $id_parceiro = addslashes($_REQUEST['id_parceiro']);
        
        $recusar = recusaParceiro($id_parceiro);

        if($recusar === true){
            header('location: ../../parceiros.php?r=1');
            exit();
        }else{
            header('location: ../../parceiros.php?e=2');
            exit();
        }
    }
