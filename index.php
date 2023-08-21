<?php
  session_start();

  if($_SESSION['token'] != "" && !is_null($_SESSION['token']) && isset($_SESSION['token'])) {
    header("location: home.php");
    exit();
  }

  if($_REQUEST['e'] == 1){
    $erro = 1;
    $msg_erro = "Todos os campos são obrigatórios.";
  }else if($_REQUEST['e'] == 2){
    $erro = 1;
    $msg_erro = "Erro ao tentar fazer o login.";
  }
?>

<!doctype html>
<html style="background-color: #071931 !important;">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <title>MV Transfers - System</title>
    
    <!--     Fonts and icons     -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  </head>

  <body>
    <div class="wrapper">
      <div class="main-panel" style="height: 100vh; width: 100vw; background-color: #071931 !important;">
        <?php if($erro == 1){ ?>
          <div style="display: flex; justify-content: flex-end; top: 20px; right: 10px; position: absolute; width: 400px;">
            <div class="alert alert-danger alert-dismissible fade show col-md-12">
              <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="nc-icon nc-simple-remove"></i>
              </button>
              <span><b>Ops!</b> <?=$msg_erro;?></span>
            </div>
          </div>
        <?php } ?>

        <div class="content" style="display: flex; justify-content: center; align-items: center;">
          <div class="card" style="width: 40rem; display: flex; flex-direction: column; align-items: center; padding: 20px;">
              <img class="card-img-top" src="assets/img/logo_color_01.png" alt="Logo MV Transfers" style="width: 25%;">
              
              <div class="card-body" style="width: 30rem;">
                <form action="assets/actions/login.php" method="post">
                  <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" name="login" id="login" placeholder="Digite aqui..." required>
                  </div>

                  <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control mb-2" name="senha" id="senha" placeholder="Digite aqui..." required>
                    <small><a href="recuperar.html" class="text text-danger font-weight-bold" style="text-decoration: none;">Esqueci minha senha</a></small>
                  </div>
                
                  <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%;">
                    <input type="submit" name="entrar" value="Entrar" class="btn btn-primary col-3">
                  </div>
                </form>
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