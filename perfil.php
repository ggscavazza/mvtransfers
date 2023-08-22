<?php
  session_start();
  include("assets/lib/funcoes.php");
  include("assets/lib/validate.php");

  $nome = $_SESSION['nome'];
  $token = $_SESSION['token'];

  $retorno = buscaPerfil($token);

  if($_REQUEST['e'] == 1){
    $erro = 1;
    $msg_erro = "As senhas digitadas não são iguais.";    
  }else if($_REQUEST['e'] == 2){
    $erro = 1;
    $msg_erro = "O campo de repetir senha está vazio.";
  }else if($_REQUEST['e'] == 3){
    $erro = 1;
    $msg_erro = "Erro ao tentar atualizar o perfil.";
  }

  if($_REQUEST['a'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Perfil atualizado com sucesso.";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include("assets/includes/head.php"); ?>
  </head>

  <body class="">
    <div class="wrapper">
      <?php include("assets/includes/sidebar.php"); ?>

      <div class="main-panel"  style="height: 100vh;">
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
            <div class="col-md-6">
              <div class="card card-user">
                <div class="card-header">
                  <h5 class="card-title">Meu perfil</h5>
                </div>

                <div class="card-body">
                  <form action="assets/actions/perfil.php" method="post">
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          <label>Nome</label>
                          <input type="text" class="form-control" placeholder="Digite aqui..." name="nome" value="<?=$retorno['nome'];?>" required>
                        </div>
                      </div>

                      <div class="col-md-3 px-1">
                        <div class="form-group">
                          <label>Telefone</label>
                          <input type="text" name="tel" class="form-control" placeholder="Digite aqui..." value="<?=$retorno['telefone'];?>" required>
                        </div>
                      </div>

                      <div class="col-md-4 pl-1">
                        <div class="form-group">
                          <label>E-mail</label>
                          <input type="email" name="email" class="form-control" placeholder="Digite aqui..." value="<?=$retorno['email'];?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 pr-1">
                        <div class="form-group">
                          <label>Nova senha</label>
                          <input type="password" name="senha" class="form-control" placeholder="Digite aqui...">
                        </div>
                      </div>

                      <div class="col-md-6 pl-1">
                        <div class="form-group">
                          <label>Repita a senha</label>
                          <input type="password" name="senha2" class="form-control" placeholder="Repita aqui...">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="update ml-auto mr-auto">
                        <input type="hidden" name="id_perfil" value="<?=$retorno['id'];?>">
                        <input type="submit" class="btn btn-primary" name="atualizar" value="Atualizar perfil">
                      </div>
                    </div>
                  </form>
                </div>
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