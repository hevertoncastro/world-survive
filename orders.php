<?php
/*
//INCLUI CLASSES
require_once('include/security.inc.php');
require_once('include/conection.inc.php');
require_once('class/MySQL.class.php');
require_once('class/ColetaVO.php');
require_once('class/coleta.class.php');
require_once('class/UsuarioVO.php');
require_once('class/usuario.class.php');
require_once('class/CooperativaVO.php');
require_once('class/cooperativa.class.php');
require_once('class/LogVO.php');
require_once('class/log.class.php');
require_once('class/mapsapi.class.php');
require_once('include/converDate.php');

//RECUPERA ID DA SESSÃO DO USUÁRIO
$usuarioID = $_SESSION["login_usuario"]["id"];
$coletaID = $_SESSION["coleta"]["id"];
$cooID = $_SESSION["coleta"]["cooperativa"];

//VERIFICA SE TEM PERMISSÃO
if (empty($coletaID) || empty($cooID)){
  header("Location: login?res=sem_permissao");
  exit;
}

//INSTANCIA A CLASSE
$Coleta = new Coleta;
$oColetaVO = new ColetaVO;

//CARREGA COOPERATIVA
$oColetas = $Coleta->consultarColeta($coletaID);

//DADOS DA COLETA
$colData = convertDate($oColetas->getData());
$colPeriodo = $oColetas->getPeriodo();
$x = array("m"=>"Manhã", "t"=>"Tarde", "n"=>"Noite");
$colPeriodo = $x[$colPeriodo];

//DADOS DO USUÁRIO
$usuLat = $_SESSION["login_usuario"]["latitude"];
$usuLng = $_SESSION["login_usuario"]["longitude"];

//INSTANCIA A CLASSE
$Cooperativa = new Cooperativa;
$oCooperativaVO = new CooperativaVO;

//CARREGA COOPERATIVA
$oCooperativas = $Cooperativa->consultarCooperativa($cooID);

//DADOS DA COOPERATIVA
$cooNome = $oCooperativas->getNome();
$cooTelefone = $oCooperativas->getTelefone();
$cooLat = number_format($oCooperativas->getLatitude(),6);
$cooLng = number_format($oCooperativas->getLongitude(),6);

//INSTANCIA CLASSE
$ApiMaps = new ApiMaps;

//CONVERTE ENDEREÇO PRA STRING ÚNICA
$cooEnderecoFormatado = $ApiMaps->formatAddress($oCooperativas->getEndereco(), $oCooperativas->getNumero(), $oCooperativas->getCidade(), $oCooperativas->getEstado(), $oCooperativas->getCep());

*/
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
        <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDR8Kf7ryhRwXsSB10tk2_MeGP2OnFdBoQ&callback=initMap"></script>
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

          <div class="row">
              <div class="input-field col s12 m6 l6">
                <h2 class="form-title">Agendamentos</h2>
              </div>
              <div class="input-field col s12 m6 l4 date-orders">
                <i class="material-icons prefix icon-datapicker">today</i>
                <input type="date" name="data" id="data" tabindex="3" class="datepicker">
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
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>Alvin</td>
                  <td>30 a 50 kg</td>
                  <td>Manhã</td>
                  <td>Endereço</td>
                  <td>
                    <label for="periodo" class="select-label">Em que período?</label>
                    <select name="periodo" id="periodo" tabindex="4" class="browser-default">
                      <option value="" selected>Selecione o período</option>
                      <option value="m">Manhã</option>
                      <option value="t">Tarde</option>
                      <option value="n">Noite</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Alvin</td>
                  <td>30 a 50 kg</td>
                  <td>Manhã</td>
                  <td>Endereço</td>
                  <td>
                    <label for="periodo" class="select-label">Em que período?</label>
                    <select name="periodo" id="periodo" tabindex="4" class="browser-default">
                      <option value="" selected>Selecione o período</option>
                      <option value="m">Manhã</option>
                      <option value="t">Tarde</option>
                      <option value="n">Noite</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Alvin</td>
                  <td>30 a 50 kg</td>
                  <td>Manhã</td>
                  <td>Endereço</td>
                  <td>
                    <label for="periodo" class="select-label">Em que período?</label>
                    <select name="periodo" id="periodo" tabindex="4" class="browser-default">
                      <option value="" selected>Selecione o período</option>
                      <option value="m">Manhã</option>
                      <option value="t">Tarde</option>
                      <option value="n">Noite</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>




            <!-- Modal Structure -->
            <div id="modal1" class="modal">
              <div class="modal-content">
                <h4>Modal Header</h4>
                <p>A bunch of text</p>
              </div>
              <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
              </div>
            </div>


            <div class="row">
              <div id="map"></div>
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
        <script src="js/main.js"></script>
        <script src="js/login.js"></script>
        <script>
        /*
        var map;
        function initMap() {
          var origin = {lat: <?php echo $usuLat ?>, lng: <?php echo $usuLng ?>};
          var destination = {lat: <?php echo $cooLat ?>, lng: <?php echo $cooLng ?>};

          var map = new google.maps.Map(document.getElementById('map'), {
            center: origin,
            scrollwheel: false,
            zoom: 8
          });

          var directionsDisplay = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers : true,
            suppressInfoWindows: false,
          });

          var home = 'img/home.png';
          var beachMarker = new google.maps.Marker({
            position: origin,
            map: map,
            icon: home
          });

          var recycle = 'img/recycle.png';
          var beachMarker = new google.maps.Marker({
            position: destination,
            map: map,
            icon: recycle
          });


          // Set destination, origin and travel mode.
          var request = {
            destination: destination,
            origin: origin,
            travelMode: google.maps.TravelMode.DRIVING
          };

          // Pass the directions request to the directions service.
          var directionsService = new google.maps.DirectionsService();
          directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
              // Display the route on the map.
              directionsDisplay.setDirections(response);
            }
          });
        }
        */
        </script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
        /*(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');*/

        (function ($) {

          $(document).ready(function(){
            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
            $('.modal-trigger').leanModal();
          });

          //DATA PICKER
            $input = $('.datepicker').pickadate({
              selectMonths: true, // Creates a dropdown to control month
              selectYears: 2 // Creates a dropdown of 15 years to control year
            });
            data_padrao = "";
            picker = $input.pickadate('picker');
            //FORMATA DATA
            picker.on('close', function() {
              data_padrao = picker.get('select', 'yyyy/mm/dd');
            })

            //ABRE DATAPICKER PELO ÍCONE
            $(".icon-datapicker").on("click focusout", function(event){
              picker.open(false);
              event.stopPropagation();
            });

        }(jQuery));
        </script>
    </body>
</html>
