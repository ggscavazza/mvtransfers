<?php
  session_start();
  include("assets/lib/funcoes.php");
  include("assets/lib/validate.php");

  $nome = $_SESSION['nome'];
  $token = $_SESSION['token'];

  if($_REQUEST['ver_ativos']) {
    $status = 1; // Status dos usuarios que preencherão a lista. As opções são: 0 - inativo | 1 - ativo
  } else if($_REQUEST['ver_inativos']) {    
    $status = 0; // Status dos usuarios que preencherão a lista. As opções são: 0 - inativo | 1 - ativo
  } else {
    $status = 1; // Status dos usuarios que preencherão a lista. As opções são: 0 - inativo | 1 - ativo
  }

  $retorno = buscaUsuarios($status);

  if($_REQUEST['e'] == 1){
    $erro = 1;
    $msg_erro = "Erro ao tentar ativar usuário.";
  }else if($_REQUEST['e'] == 2){
    $erro = 1;
    $msg_erro = "Erro ao tentar inativar usuário.";
  }

  if($_REQUEST['a'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Usuário ativado com sucesso.";
  }
  
  if($_REQUEST['r'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Usuário inativado com sucesso.";
  }
?>

<!doctype html>
<html>
  <head>
    <?php include("assets/includes/head.php"); ?>
  </head>

  <body class="">
    <div class="wrapper ">
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
                    <h4 class="card-title"> Usuários inativos</h4>
                  <?php } else { ?>
                    <h4 class="card-title"> Usuários ativos</h4>
                  <?php } ?>
                </div>

                <div class="card-body">
                  <div class="table">
                    <table class="table table-striped">
                      <thead class=" text-primary">
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Tipo</th>
                        <th></th>
                      </thead>

                      <tbody>
                        <?php while($dados = mysqli_fetch_array($retorno)){ ?>
                          <?php
                            $id_tipo = $dados['tipo'];
                            $nome_tipo = buscaTipoUsuario($id_tipo);
                          ?>
                          <tr>
                            <td><?=$dados['nome'];?></td>
                            <td><?=$dados['email'];?></td>
                            <td><?=$dados['telefone'];?></td>
                            <td><?=$nome_tipo;?></td>
                            <td>                            
                              <form action="assets/actions/usuario.php" method="post">
                                <div class="form-group">
                                  <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; gap: 10px;">
                                    <input type="hidden" name="id_usuario" value="<?=$dados['id'];?>">

                                    <?php if($status == 0 && $dados['tipo'] != 1){ ?>
                                      <input type="submit" class="btn btn-success" name="aceitar" value="Ativar">
                                    <?php } ?>

                                    <?php if($status == 1 && $dados['tipo'] != 1){ ?>
                                      <input type="submit" class="btn btn-danger" name="recusar" value="Inativar">
                                    <?php } ?>
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
                    <?php if($status == 0){ ?>
                      <input type="submit" class="btn btn-info" name="ver_ativos" value="Ver ativos">
                    <?php }else{ ?>
                      <input type="submit" class="btn btn-danger" name="ver_inativos" value="Ver inativos">
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
