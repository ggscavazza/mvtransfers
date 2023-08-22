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
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    MV Transfers - System
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <!-- data-color: white || black / data-active-color: primary || info || success || warning || danger -->
    <div class="sidebar" data-color="black" data-active-color="info"> 
      <div class="logo" style="display:flex; justify-content: center;">
        <a href="home.php" class="simple-text logo-normal bg-light" style="border-radius: 150px; padding: 15px; width: 150px; height: 150px; display: flex; justify-content: center; align-items: center;">
          <div class="logo-image-big" style="width: auto;">
            <img src="assets/img/logo_color_01.png" width="100%">
          </div>
        </a>
      </div>

      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="home.php">
              <i class="nc-icon nc-pin-3"></i>
              <p>Viagens</p>
            </a>
          </li>
          <li class="active">
            <a href="parceiros.php">
              <i class="nc-icon nc-delivery-fast"></i>
              <p>Parceiros</p>
            </a>
          </li>
          <li>
            <a href="usuarios.php">
              <i class="nc-icon nc-circle-10"></i>
              <p>Usuários</p>
            </a>
          </li>
          <li>
            <a href="perfil.php">
              <i class="nc-icon nc-touch-id"></i>
              <p>Perfil</p>
            </a>
          </li>          
          <li>
            <a href="desconectar.php">
              <i class="nc-icon nc-button-power"></i>
              <p>Sair</p>
            </a>
          </li>
        </ul>
      </div>
    </div>

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
                                <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%;">
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
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
</body>

</html>
