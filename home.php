<?php
  session_start();
  include("assets/lib/funcoes.php");
  //include("assets/lib/validate.php");

  $nome = $_SESSION['nome'];
  $token = $_SESSION['token'];

  $status = 2; // Status das viagens que preencherão a lista. As opções são: 0 - cancelada | 1 - aprovada | 2 - em analise
  $retorno = buscaViagens($status);
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
          <li class="active">
            <a href="home.php">
              <i class="nc-icon nc-pin-3"></i>
              <p>Viagens</p>
            </a>
          </li>
          <li>
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

      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Viagens para análise</h4>
              </div>

              <div class="card-body">
                <div class="table">
                  <table class="table table-striped">
                    <thead class=" text-primary">
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Telefone</th>
                      <th>Trajeto</th>
                      <th>Informações</th>
                    </thead>

                    <tbody>
                      <?php while($dados = mysqli_fetch_array($retorno)){ ?>
                        <?php
                          $tkn_cliente = $dados['solicitante'];
                          $nome_cliente = buscaNome($tkn_cliente);
                          $email_cliente = buscaEmail($tkn_cliente);
                          $tel_cliente = buscaTelefone($tkn_cliente);
                          $data_bruta = explode('-', $dados['data_ida']);
                          $data_ida = $data_bruta[2].'/'.$data_bruta[1].'/'.$data_bruta[0];
                          $viatura = $dados['tipo_carro'];

                          if($viatura == "pequena"){
                            $tam_viatura = "5 lugares";
                          }else if($viatura == "grande"){
                            $tam_viatura = "9 lugares";
                          }else{
                            $tam_viatura = "7 lugares";
                          }
                        ?>
                        <tr>
                          <td><?=$nome_cliente;?></td>
                          <td><?=$email_cliente;?></td>
                          <td><?=$tel_cliente;?></td>
                          <td>
                            <b>DE:</b> <?=$dados['origem'];?><br>
                            <b>PARA:</b> <?=$dados['destino'];?>
                          </td>
                          <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tkn_cliente">
                              Ver detalhes
                            </button>
                          </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="tkn_cliente" tabindex="-1" role="dialog" aria-labelledby="tkn_clienteLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="tkn_clienteLabel"><?=$nome_cliente;?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">
                                <form action="assets/actions/viagem.php">
                                  <fieldset disabled>
                                    <div class="form-group">
                                      <label for="disabledNome">Nome:</label>
                                      <input type="text" id="disabledNome" class="form-control" placeholder="<?=$nome_cliente;?>">
                                    </div>
                                    
                                    <div class="form-group">
                                      <label for="disabledEmail">E-mail:</label>
                                      <input type="text" id="disabledEmail" class="form-control" placeholder="<?=$email_cliente;?>">
                                    </div>

                                    <div class="form-group">
                                      <label for="disabledTel">Telefone:</label>
                                      <input type="text" id="disabledTel" class="form-control" placeholder="<?=$tel_cliente;?>">
                                    </div>                                    

                                    <div class="form-group">
                                      <label for="disabledTrajeto">Trajeto:</label>
                                      <input type="text" id="disabledTrajeto" class="form-control" placeholder="DE: <?=$dados['origem'];?> | PARA: <?=$dados['destino'];?>">
                                    </div>

                                    <div class="form-group">
                                      <label for="disabledData">Quando?</label>
                                      <input type="text" id="disabledData" class="form-control" placeholder="<?=$data_ida;?> às <?=$dados['hora_ida'];?>">
                                    </div>

                                    <div style="display: flex; justify-content: space-between; width: 100%; gap: 15px;">                                      
                                      <div class="form-group">
                                        <label for="disabledPessoas">Quantas pessoas?</label>
                                        <input type="text" id="disabledPessoas" class="form-control" placeholder="<?=$dados['qnt_pessoas'];?>">
                                      </div>
  
                                      <div class="form-group">
                                        <label for="disabledCriancas">Quantas crianças?</label>
                                        <input type="text" id="disabledCriancas" class="form-control" placeholder="<?=$dados['qnt_criancas'];?>">
                                      </div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; width: 100%; gap: 15px;">
                                      <div class="form-group">
                                        <label for="disabledMalas">Quantas malas?</label>
                                        <input type="text" id="disabledMalas" class="form-control" placeholder="<?=$dados['qnt_malas'];?>">
                                      </div>

                                      <div class="form-group">
                                        <label for="disabledViatura">Tamanho da viatura:</label>
                                        <input type="text" id="disabledViatura" class="form-control" placeholder="<?=$tam_viatura;?>">
                                      </div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; width: 100%; gap: 15px;">
                                      <div class="form-group">
                                        <label for="disabledValor">Valor estimado:</label>
                                        <input type="text" id="disabledValor" class="form-control" placeholder="<?=$dados['valor_viagem'];?> €">
                                      </div>

                                      <div class="form-group">
                                        <label for="disabledTempo">Tempo estimado:</label>
                                        <input type="text" id="disabledTempo" class="form-control" placeholder="<?=$dados['tempo_viagem'];?>">
                                      </div>

                                      <div class="form-group">
                                        <label for="disabledDist">Distância:</label>
                                        <input type="text" id="disabledDist" class="form-control" placeholder="<?=$dados['distancia'];?> KM">
                                      </div>
                                    </div>
                                  </fieldset>

                                  <div class="mb-2" style="display: flex; justify-content: flex-end; width: 100%;">
                                    <input type="hidden" name="tkn_solicitante" value="<?=$tkn_cliente;?>">
                                    <input type="hidden" name="id_viagem" value="<?=$dados['id'];?>">
                                    <input type="submit" class="btn btn-success" name="aceitar" value="Aceitar">
                                    <input type="submit" class="btn btn-danger" name="recusar" value="Recusar">
                                  </div>
                                </form>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>                      
                    </tbody>
                  </table>
                </div>
              </div>
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
