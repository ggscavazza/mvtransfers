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

  if($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2) {
    $retorno = buscaViagens($status);
  }else{
    $retorno = buscaMinhasViagens($status, $token);
  }

  if($_REQUEST['e'] == 1){
    $erro = 1;
    $msg_erro = "Erro ao tentar aceitar a viagem.";
  }else if($_REQUEST['e'] == 2){
    $erro = 1;
    $msg_erro = "Erro ao tentar recusar a viagem.";
  }

  if($_REQUEST['a'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Viagem aceita com sucesso.";
  }
  
  if($_REQUEST['r'] == 1){
    $sucesso = 1;
    $msg_sucesso = "Viagem recusada com sucesso.";
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
                    <h4 class="card-title"> Viagens recusadas</h4>
                  <?php } else if($status == 1) { ?>
                    <h4 class="card-title"> Viagens aceitas</h4>
                  <?php } else { ?>
                    <h4 class="card-title"> Viagens em análise</h4>
                  <?php } ?>
                </div>

                <div class="card-body">
                  <div class="table">
                    <table class="table table-striped">
                      <?php if($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2){ ?>
                        <thead class=" text-primary">
                          <th>Viagem</th>
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
                              <td><?=$dados['cod_viagem'];?></td>
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
                                    <form action="assets/actions/viagem.php" method="post">
                                      <fieldset disabled>
                                        <div class="form-group">
                                          <label for="disabledPickup">Endereço de pick up:</label>
                                          <input type="text" id="disabledPickup" class="form-control" placeholder="<?=$dados['endereco_partida'];?>">
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="disabledDropoff">Endereço de drop off:</label>
                                          <input type="text" id="disabledDropoff" class="form-control" placeholder="<?=$dados['endereco_destino'];?>">
                                        </div>

                                        <div class="form-group">
                                          <label for="disabledVoo">Nº do Voo:</label>
                                          <input type="text" id="disabledVoo" class="form-control" placeholder="<?php if($dados['cod_voo']!="" && !is_null($dados['cod_voo'])){ echo $dados['cod_voo']; }else{ echo "Não se aplica"; } ?>">
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
                                            <label for="disabledTempo">Tempo estimado:</label>
                                            <input type="text" id="disabledTempo" class="form-control" placeholder="<?=$dados['tempo_viagem'];?>">
                                          </div>

                                          <div class="form-group">
                                            <label for="disabledDist">Distância:</label>
                                            <input type="text" id="disabledDist" class="form-control" placeholder="<?=$dados['distancia'];?> KM">
                                          </div>
                                        </div>
                                      </fieldset>
                                      
                                      <div class="form-group">
                                        <label for="valor">Valor estimado (€):</label>
                                        <input type="text" id="valor" class="form-control" name="valor_correto" value="<?=$dados['valor_viagem'];?>">
                                      </div>
                                      
                                      <div class="mb-2" style="display: flex; justify-content: flex-end; gap: 15px; width: 100%;">
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
                      <?php }else{ ?>
                        <thead class=" text-primary">
                          <th>Trajeto</th>
                          <th>Quando?</th>
                          <th>Viatura</th>
                          <th>Valor €</th>
                          <th>Tempo estimado</th>
                          <th>Distância</th>
                        </thead>

                        <tbody>
                          <?php while($dados = mysqli_fetch_array($retorno)){ ?>
                            <?php
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
                              <td>
                                <b>DE:</b> <?=$dados['origem'];?><br>
                                <b>PARA:</b> <?=$dados['destino'];?>
                              </td>
                              <td><?=$data_ida;?> às <?=$dados['hora_ida'];?></td>
                              <td><?=$tam_viatura;?></td>
                              <td><?=$dados['valor_viagem'];?> €</td>
                              <td><?=$dados['tempo_viagem'];?></td>
                              <td><?=$dados['distancia'];?> KM</td>
                            </tr>
                          <?php } ?>                      
                        </tbody>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end;">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                  <div class="form-group" style="display: flex; gap: 10px;">
                    <?php if($status == 2 || $status == 0){ ?>
                      <input type="submit" class="btn btn-success" name="ver_aceitas" value="Ver aceitas">
                    <?php } ?>
                    
                    <?php if($status == 1 || $status == 0){ ?>
                      <input type="submit" class="btn btn-info" name="ver_analises" value="Ver em análise">
                    <?php } ?>

                    <?php if($status == 2 || $status == 1){ ?>
                      <input type="submit" class="btn btn-danger" name="ver_recusadas" value="Ver recusadas">
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
