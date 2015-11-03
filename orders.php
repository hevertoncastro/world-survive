<?php
//INCLUI CLASSES
require_once('include/securityadm.inc.php');
require_once('include/conection.inc.php');
require_once('class/MySQL.class.php');
require_once('class/ColetaVO.php');
require_once('class/coleta.class.php');
require_once('class/UsuarioVO.php');
require_once('class/usuario.class.php');
require_once('class/CooperativaVO.php');
require_once('class/cooperativa.class.php');
require_once('class/FuncionarioVO.php');
require_once('class/funcionario.class.php');
require_once('class/LogVO.php');
require_once('class/log.class.php');
require_once('class/mapsapi.class.php');
require_once('include/converDate.php');

//RECUPERA ID DA SESSÃO DO USUÁRIO
$cooID = $_SESSION["login_cooperativa"]["id"];

//VERIFICA SE TEM PERMISSÃO
if (empty($cooID) || empty($cooID)){
  header("Location: adm?res=sem_permissao");
  exit;
}

//PEGA AÇÃO POR GET
$dataColeta = (isset($_GET['d']) && strlen($_GET['d'])>9) ? convertDate($_GET['d']) : date('Y-m-d');
//BOTÃO PRÓXIMO DIA E DIA ANTERIOR
$beforeDay = convertDate(date('Y-m-d', strtotime("-1 day", strtotime($dataColeta))));
$afterDay = convertDate(date('Y-m-d', strtotime("+1 day", strtotime($dataColeta))));

//INSTANCIA A CLASSE
$Coleta = new Coleta;

//CARREGA COOPERATIVA
$oColetas = $Coleta->carregarColetas(" AND col_situacao!='excluido' AND coo_id='".$cooID."' AND col_data='".$dataColeta."'","col_qtde DESC, col_periodo ='m' DESC, col_periodo DESC","");


//INSTANCIA A CLASSE
$Cooperativa = new Cooperativa;

//CARREGA COOPERATIVA
$oCooperativas = $Cooperativa->consultarCooperativa($cooID);

//DADOS DA COOPERATIVA
$cooNome = $oCooperativas->getNome();
$cooLat = number_format($oCooperativas->getLatitude(),6);
$cooLng = number_format($oCooperativas->getLongitude(),6);
$cooCoord = $cooLat."%2C".$cooLng;

//INSTANCIA CLASSE
$ApiMaps = new ApiMaps;

//INSTANCIA A CLASSE
$Usuario = new Usuario;

//INSTANCIA A CLASSE
$funcionario = new funcionario;
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php include_once("include/seo-data.php") ?>

        <!--Normalize CSS-->
        <link rel="stylesheet" href="css/normalize.min.css">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
        <link rel="stylesheet" href="css/main.css">

        <!--[if lt IE 9]>
            <script src="js/vendor/html5-3.6-respond-1.4.2.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <nav class="white" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="index" class="brand-logo"><img src="img/logo-world-survive.png" height="200" width="270" alt=""></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="logoff">Sair</a></li>
          </ul>

           <ul id="nav-mobile" class="side-nav">
            <li><a href="logoff">Sair</a></li>
          </ul>
          <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
        </nav>

        <div class="section row form-orders">

          <div class="row col s12 center">
            <h1 class="coo-title grey-text text-darken-2">Cooperativa de Catadores da Baixada do Glicério</h2>
          </div>
          <div class="row">
              <div class="input-field col s12 m12 l5">
                <h2 class="form-title">Agendamentos</h2>
              </div>
              <div class="input-field col s6 m6 l4 date-orders">
                <i class="material-icons prefix icon-datapicker">today</i>
                <input type="date" name="data" id="data" tabindex="3" class="datepicker">
              </div>
              <div class="input-field col s6 m6 l3 no-print">
                 <a href="orders?d=<?php echo $beforeDay ?>" class="tooltipped grey-text text-darken-3" data-position="top" data-delay="0" data-tooltip="Dia anterior"><i class="order-icon material-icons">skip_previous</i></a>
                 <a href="orders?d=<?php echo $afterDay ?>" class="tooltipped grey-text text-darken-3" data-position="top" data-delay="0" data-tooltip="Próximo dia"><i class="order-icon material-icons">skip_next</i></a>
                 <a href="" class="tooltipped grey-text text-darken-3" data-position="top" data-delay="0" data-tooltip="Imprimir" onclick="window.print();return false;"><i class="order-icon material-icons">print</i></a>
              </div>
            </div>
          <form class="col s12" role="form" onSubmit="return false;">



            <table class="responsive-table striped highlight">
              <thead>
                <tr>
                    <th data-field="nome">Nome</th>
                    <th data-field="qtde">Quantidade</th>
                    <th data-field="periodo">Período</th>
                    <th data-field="endereco">Endereço</th>
                    <th data-field="responsavel">Responsável</th>
                    <th data-field="responsavel" class="no-print">Ações</th>
                </tr>
              </thead>

              <tbody>

                <?php
                $qtdes = array(10=>"Menos de 10 kg", 30=>"Entre 10 e 30 kg", 50=>"Entre 30 e 50 kg", 100=>"Entre 50 e 100 kg", 150=>"Mais de 100 kg");

                $coresQtdes = array(10=>"teal-text", 30=>"lime-text text-darken-3", 50=>"amber-text text-accent-4 bold", 100=>"amber-text text-darken-4 bold", 150=>"red-text bold");

                $periodos = array("m"=>"Manhã", "t"=>"Tarde", "n"=>"Noite");

                if($oColetas){
                  foreach($oColetas as $col){

                  $coletaID = $col->getColetaID();

                  $oUsuario = $Usuario->consultarUsuario($col->getUsuarioID());

                  //CONVERTE ENDEREÇO PRA STRING ÚNICA
                  $usuEnderecoFormatado = $ApiMaps->formatShortAddress($oUsuario->getEndereco(), $oUsuario->getNumero());

                  //CONVERTE ENDEREÇO PRA STRING ÚNICA
                  $usuEnderecoCompleto = $ApiMaps->formatAddress($oUsuario->getEndereco(), $oUsuario->getNumero(), $oUsuario->getCidade(), $oUsuario->getEstado(), $oUsuario->getCep());

                ?>
                <tr>
                  <td><?php echo $oUsuario->getNome() ?></td>
                  <td class="<?php echo $coresQtdes[$col->getQtde()] ?>"><?php echo $qtdes[$col->getQtde()] ?></td>
                  <td><?php echo $periodos[$col->getPeriodo()] ?></td>
                  <?php
                  $usuCoord = $oUsuario->getLatitude()."%2C".$oUsuario->getLongitude();
                  ?>
                  <td><a href="" onclick="changeMap('<?php echo $cooCoord ?>','<?php echo $usuCoord ?>','<?php echo $usuEnderecoCompleto ?>'); return false;"><?php echo $usuEnderecoFormatado ?> <i class="tiny material-icons no-print">my_location</i></a></td>
                  <td>
                    <select name="worker" id="worker<?php echo $coletaID ?>" tabindex="4" class="browser-default funRes" onchange="changeWorker('<?php echo $coletaID ?>',this.value); return false;"<?php if ($col->getSituacao()=="realizado" || $col->getSituacao()=="cancelado") echo " disabled"; ?>>

                      <option value="" selected>Selecione</option>
                      <?php
                      $ofuncionarios = $funcionario->carregarFuncionarios("","fun_nome ASC","");
                      foreach($ofuncionarios as $fun){
                      ?>
                      <option value="<?php echo $fun->getFuncionarioID() ?>"<?php if($col->getFuncionarioID() == $fun->getFuncionarioID()) echo ' selected';?>><?php echo $fun->getNome() ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </td>
                  <td class="no-print">
                    <!-- Botão excluir -->
                    <a href="#modalDelete" class="tooltipped modal-trigger" data-position="top" data-delay="0" data-tooltip="excluir" onclick="javascript: document.getElementById('deleteid').value = '<?php echo $coletaID ?>'"><i class="material-icons red-text text-accent-2">delete</i></a>

                    <!-- Botão detalhes -->
                    <a href="" class="tooltipped" data-position="top" data-delay="0" data-tooltip="detalhes" onclick="changeMap('<?php echo $cooCoord ?>','<?php echo $usuCoord ?>','<?php echo $usuEnderecoCompleto ?>'); return false;"><i class="material-icons">zoom_in</i></a>

                    <!-- Botão status -->
                    <?php
                    $iconStatus = array('pendente'=>'schedule', 'realizado'=>'done_all', 'cancelado'=>'not_interested');
                    $corStatus = array('realizado'=>'teal-text', 'pendente'=>'amber-text text-accent-4', 'cancelado'=>'red-text');
                    ?>
                    <a href="#" id="db<?php echo $coletaID ?>" class="dropdown-button tooltipped <?php echo $corStatus[$col->getSituacao()]; ?>" data-position="top" data-delay="0" data-tooltip="<?php echo $col->getSituacao() ?>" data-activates="dropdown<?php echo $coletaID ?>"><i class="material-icons"><?php echo $iconStatus[$col->getSituacao()]; ?></i></a>

                    <!-- Ações de status -->
                    <ul id="dropdown<?php echo $coletaID ?>" class="dropdown-content">
                      <li><a href="" class="teal-text" onclick="changeStatus('<?php echo $coletaID ?>','realizado'); return false;">Realizado</a></li>
                      <li class="divider"></li>
                      <li><a href="" class="amber-text text-accent-4" onclick="changeStatus('<?php echo $coletaID ?>','pendente'); return false;">Pendente</a></li>
                      <li class="divider"></li>
                      <li><a href="" class="red-text" onclick="changeStatus('<?php echo $coletaID ?>','cancelado'); return false;">Cancelado</a></li>
                    </ul>
                  </td>
                </tr>
                <?php
                  }
                } else {
                ?>
                <tr>
                  <td colspan="6" class="center">Nenhuma coleta agendada para esta data.</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <!-- Modal Delete -->
            <div id="modalDelete" class="modal modal-delete">
              <div class="modal-content">
                <h4>Tem certeza?</h4>
                <p>Todos os dados deste agendamento serão excluídos.</p>
              </div>
              <div class="modal-footer">
                <a href="" class="modal-action modal-close waves-effect waves-red btn" onclick="confirmDelete(document.getElementById('deleteid').value); return false;">Confirmar</a>
                <a href="" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="return false;">Cancelar</a>
              </div>
            </div>
            <input type="hidden" name="deleteid" id="deleteid">

            <!-- Modal Directions -->
            <div id="modalDirections" class="modal" style="height: 100%;">
              <div class="modal-content">
                <h4><?php if(isset($oUsuario)) echo $oUsuario->getNome() ?></h4>
                <!-- <p>Pedido realizado em: <?php //echo convertDate(substr($col->getInclusao(), 0,10)); ?> às <?php //echo substr($col->getInclusao(), 11,14); ?></p><br> -->
                <p id="address"></p>
                <iframe id="directions" width="100%" height="100%" frameborder="0" style="border:0; min-height: 300px;" src="" allowfullscreen></iframe> 
              </div>
              <div class="modal-footer">
                <a href="" class=" modal-action modal-close waves-effect waves-green btn-flat" onclick="return false;">FECHAR</a>
              </div>
            </div>
          </form>
        </div>
        <footer class="page-footer teal">
        <div class="container">
        </div>
        <div class="footer-copyright">
          <div class="container">
          Todos os direitos reservados  <a class="cyan-text text-accent-1">World Survive</a>
          </div>
        </div>
        </footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/materialize.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/login.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
        /*(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');*/

        (function ($) {

            //MUDA AS COORDENADAS DO MAPA
            changeMap = function(cooCoord, usuCoord, address){

              //gera mapa com direções
              $("#directions").attr('src', 'https://www.google.com/maps/embed/v1/directions?origin='+cooCoord+'&destination='+usuCoord+'&key=AIzaSyDR8Kf7ryhRwXsSB10tk2_MeGP2OnFdBoQ');

              //gera endereço no modal
              $("#address").html(address);

              //abre modal
              $('#modalDirections').openModal({
                dismissible: true,
                complete: function() { $("#directions").attr('src', ''); } // limpa mapa
              });

            };

            //MUDA O FUNCIONÁRIO DA COLETA
            changeWorker = function(id, funcionario){

              // //ALTERA STATUS NO BANCO POR AJAX POST
              $.post("include/ajax-worker.php", {

                coletaid: id,
                worker: funcionario

              }).done(function(data){

                //VERIFICA SE FOI SELECIONADO UM FUNCIONÁRIO
                if(data == "noworker"){

                  //MOSTRA MENSAGEM DO EVENTO
                  Materialize.toast('Coleta atribuída', 3000);
                //SE NÃO HOUVE ERRO
                } else if(data == "ok"){
                  //MOSTRA MENSAGEM DO EVENTO
                  Materialize.toast('Coleta atribuída', 3000);
                }

              })
              .fail(function(err){

                console.log(err);

              });
            };


            //MUDA OS STATUS DAS COLETAS
            changeStatus = function(id, future){

              //ALTERA STATUS NO BANCO POR AJAX POST
              $.post("include/ajax-status.php", {

                coletaid: id,
                newstatus: future,
                worker: $("#worker"+id).val()

              }).done(function(data){

                //VERIFICA SE FOI SELECIONADO UM FUNCIONÁRIO
                if(data == "worker"){

                  //MOSTRA MENSAGEM DO EVENTO
                  Materialize.toast("Selecione um funcionário", 3000);
                  $("#worker"+id).focus();

                //SE NÃO HOUVE ERRO
                } else if(data == "ok"){

                  //SE MUDOU PARA REALIZADO OU CANCELADO BLOQUEIA FUNCIONÁRIO
                  if(future == "realizado" || future == "cancelado"){
                    $("#worker"+id).attr('disabled', 'disabled');
                  } else if(future == "pendente"){
                    $("#worker"+id).removeAttr('disabled');
                  }

                  $iconStatus = { pendente: 'schedule', realizado: 'done_all', cancelado: 'not_interested' };
                  $corStatus = { realizado: 'teal-text', pendente: 'amber-text text-accent-4', cancelado: 'red-text' };
                  $msgStatus = { realizado: 'Coleta realizada', pendente: 'Coleta pendente', cancelado: 'Coleta cancelada' };

                  //MUDA ÍCONE E COR
                  $('#db'+id).removeClass("teal-text amber-text text-accent-4 red-text");
                  $('#db'+id).addClass($corStatus[future]);
                  $('#db'+id+" > i").html($iconStatus[future]);

                  //MOSTRA MENSAGEM DO EVENTO
                  Materialize.toast($msgStatus[future], 3000);
                }

              })
              .fail(function(err){

                console.log(err);

              });
            };

            //DELETA AGENDAMENTO
            confirmDelete = function(id){

              //EXCLUI NO BANCO POR AJAX POST
              $.post("include/ajax-delete.php", {

                coletaid: id

              }).done(function(data){

                //SE NÃO HOUVE ERRO
                if(data == "ok"){

                  //MOSTRA MENSAGEM DO EVENTO
                  Materialize.toast('Agendamento excluído',1500);

                  setTimeout(function(){
                    location.reload();
                  }, 1500); //esconde o aviso depois um tempo

                }

              })
              .fail(function(err){

                console.log(err);

              });
            };

            $('.modal-trigger').leanModal({
                dismissible: true
              }
            );


            $('.button-collapse').sideNav();

            $('.dropdown-button').dropdown({
                belowOrigin: false, // Displays dropdown below the button
                alignment: 'left' // Displays dropdown with edge aligned to the left of button
              }
            );

            //DATA PICKER
            $input = $('.datepicker').pickadate({
              selectMonths: true, // Creates a dropdown to control month
              selectYears: 2 // Creates a dropdown of 15 years to control year
            });
            dataPadrao = "";
            picker = $input.pickadate('picker');
            //FORMATA DATA
            picker.on('close', function() {
              dataPadrao = picker.get('select', 'dd/mm/yyyy');
              window.location = 'orders?d='+dataPadrao;
            })

            //PEGA VALOR DE GET
            var getUrl = function getParameterByName(name){
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
              results = regex.exec(location.search);
              return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            if(getUrl('d').length > 9){

              var dataAtual = getUrl('d').split("/");
              picker.set('select', [dataAtual[2], dataAtual[1]-1, dataAtual[0]])

            } else {
              picker.set('select', new Date())
            }

            //ABRE DATAPICKER PELO ÍCONE
            $(".icon-datapicker").on("click focusout", function(event){
              picker.open(false);
              event.stopPropagation();
            });

        }(jQuery));
        </script>
    </body>
</html>
