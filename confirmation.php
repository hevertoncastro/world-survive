<?php
//INCLUI CLASSES
require_once('include/securityshare.inc.php');
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

        <div class="section row form-login">
          <h2 class="form-title">Agendamento realizado!</h2>
          <form class="col s12" role="form" onSubmit="return false;">
            <div class="row">
              <a class="waves-effect waves-light btn btn-large btn-share" tabindex="4">COMPARTILHAR</a>
              <a href="logoff" class="waves-effect waves-teal btn-flat btn-large">SAIR</a>
            </div>
            <div class="row share">
              <div class="pw-widget pw-counter-vertical">
                <a class="pw-button-facebook pw-look-native"></a>
                <a class="pw-button-twitter pw-look-native"></a>
                <a class="pw-button-googleplus pw-look-native"></a>
                <a class="pw-button-email pw-look-native"></a>
              </div>
              <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=mjegnr0kqs6c2kv0qija&retina=true" type="text/javascript"></script>
            </div>
            <div class="row">
              <p><span class="bold">A coleta será feita pela cooperativa:</span><br>
              <?php echo $cooNome ?><br>
              <span class="bold">Data da coleta:</span> <?php echo $colData ?><br>
              <span class="bold">Período:</span> <?php echo $colPeriodo ?><br>
              <span class="bold">Telefone de contato:</span> <?php echo $cooTelefone ?></p>
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

        (function ($) {

          //BOTÕES DE COMPARTILHAMENTO
          $(".btn-share").click(function() {
            $(".share").toggle("fast");
          });

        }(jQuery));

        //Google Analytics
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-33868689-7', 'auto');
        ga('send', 'pageview');
        </script>
    </body>
</html>
