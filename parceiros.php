<?php
  session_start();
  include("assets/lib/funcoes.php");
  include("assets/lib/validate.php");

  $nome = $_SESSION['nome'];
  $token = $_SESSION['token'];

  if($_REQUEST['ver_aceitas']) {
    $status = 1; // Status das viagens que preencherão a lista. As opções são: 0 - cancelada | 1 - aprovada | 2 - em analise
  } else if($_REQUEST['ver_analises']) {
    $status = 2; // Status das viagens que preencherão a lista. As opções são: 0 - cancelada | 1 - aprovada | 2 - em analise
  } else if($_REQUEST['ver_recusadas']) {    
    $status = 0; // Status das viagens que preencherão a lista. As opções são: 0 - cancelada | 1 - aprovada | 2 - em analise
  } else {
    $status = 2; // Status das viagens que preencherão a lista. As opções são: 0 - cancelada | 1 - aprovada | 2 - em analise
  }

  $retorno = buscaParceiros($status);

  if($_REQUEST['e'] == 1){
    $erro = 1;
    $msg_erro = "Erro ao tentar aceitar parceiro.";
  }else if($_REQUEST['e'] == 2){
    $erro = 1;
    $msg_erro = "Erro ao tentar recusar parceiro.";
  }

  if($_REQUEST['a'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Parceiro aceito com sucesso.";
  }
  
  if($_REQUEST['r'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Parceiro recusado com sucesso.";
  }
?>

<!doctype html>
<html>
  <head>
    <?php include("assets/includes/head.php"); ?>
  </head>

  <body class="">
    <div class="wrapper">
      <?php include("assets/includes/sidebar.php"); ?>

      <div class="main-panel" style="height: 100vh;">
        <?php include("assets/includes/navbar.php"); ?>

        <?php if($erro == 1){ ?>
          <div style="display: flex; justify-content: flex-end; top: 110px; right: 10px; position: absolute; width: 400px; z-index: 99;">
            <div class="alert alert-danger alert-dismissible fade show col-md-12">
              <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="nc-icon nc-simple-remove"></i>
              </button>
              <span><b>Ops!</b> <?=$msg_erro;?></span>
            </div>
          </div>
        <?php } ?>

        <?php if($sucesso == 1){ ?>
          <div style="display: flex; justify-content: flex-end; top: 110px; right: 10px; position: absolute; width: 400px; z-index: 99;">
            <div class="alert alert-success alert-dismissible fade show col-md-12">
              <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="nc-icon nc-simple-remove"></i>
              </button>
              <span><b>Feito!</b> <?=$msg_sucesso;?></span>
            </div>
          </div>
        <?php } ?>

        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <?php if($status == 0) { ?>
                    <h4 class="card-title"> Parceiros recusados</h4>
                  <?php } else if($status == 1) { ?>
                    <h4 class="card-title"> Parceiros aceitos</h4>
                  <?php } else { ?>
                    <h4 class="card-title"> Parceiros em análise</h4>
                  <?php } ?>
                </div>

                <div class="card-body">
                  <div class="table">
                    <table class="table table-striped">
                      <thead class=" text-primary">
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Viatura</th>
                        <th>Onde está?</th>
                        <th></th>
                      </thead>

                      <tbody>
                        <?php while($dados = mysqli_fetch_array($retorno)){ ?>
                          <tr>
                            <td><?=$dados['nome'];?></td>
                            <td><?=$dados['email'];?></td>
                            <td><?=$dados['telefone'];?></td>
                            <td><?=$dados['carro'];?></td>
                            <td><?=$dados['localidade'];?></td>
                            <td>
                              <form action="assets/actions/parceiro.php" method="post">
                                <div class="form-group">
                                  <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; gap: 10px;">
                                    <input type="hidden" name="id_parceiro" value="<?=$dados['id'];?>">
                                    <input type="submit" class="btn btn-success" name="aceitar" value="Aceitar">
                                    <input type="submit" class="btn btn-danger" name="recusar" value="Recusar">
                                  </div>
                                </div>
                              </form>
                            </td>
                          </tr>
                        <?php } ?>                      
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end;">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                  <div class="form-group" style="display: flex; gap: 10px;">
                    <?php if($status == 2 || $status == 0){ ?>
                      <input type="submit" class="btn btn-success" name="ver_aceitas" value="Ver aceitos">
                    <?php } ?>
                    
                    <?php if($status == 1 || $status == 0){ ?>
                      <input type="submit" class="btn btn-info" name="ver_analises" value="Ver em análise">
                    <?php } ?>

                    <?php if($status == 2 || $status == 1){ ?>
                      <input type="submit" class="btn btn-danger" name="ver_recusadas" value="Ver recusados">
                    <?php } ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php include("assets/includes/footer.php"); ?>
      </div>
    </div>

    <?php include("assets/includes/scripts.php"); ?>
  </body>
</html>
