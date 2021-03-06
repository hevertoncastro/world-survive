<?php
//INCLUI CLASSES
require_once('include/security.inc.php');
require_once('include/conection.inc.php');
require_once('class/MySQL.class.php');
require_once('class/UsuarioVO.php');
require_once('class/usuario.class.php');
require_once('class/ResiduoVO.php');
require_once('class/residuo.class.php');

//INSTANCIA CLASSE
$Residuo = new Residuo;
$Usuario = new Usuario;

//CARREGA RESÍDUOS
$oResiduos = $Residuo->carregarResiduos("","res_id ASC","");

//RECUPERA ID DA SESSÃO DO USUÁRIO
$usuarioID = $_SESSION["login_usuario"]["id"];

if(isset($usuarioID) && !empty($usuarioID)){
  $oUsuario = $Usuario->consultarUsuario($usuarioID);
}
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
          <a id="logo-container" href="#" class="brand-logo"><img src="img/logo-world-survive.png" height="200" width="270" alt=""></a>
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
          <h2 class="form-title coleta">Solicite a coleta</h2>
          <form class="col s12" id="formulario" role="form" onSubmit="return false;">
            <div class="row materiais">
              <div class="input-field col s12">
                <label class="select-label">Selecione os tipos de materiais de sua doação</label>
              </div>
              <div class="lista-material">
              <?php
              $cont = 1;
              foreach($oResiduos as $aux){
              ?>
              <div class="input-field col s6 m4 l3">
                <span>
                  <input type="checkbox" value="<?php echo $aux->getResiduoID(); ?>" name="materiais[]" id="<?php echo "material_".$cont ?>">
                  <label for="<?php echo "material_".$cont ?>"><?php echo $aux->getNome(); ?></label>
                </span>
              </div>
              <?php
                $cont++;
              }
              ?>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <label for="qtde" class="select-label">Quantidade total aproximada em kg</label>
                <select name="qtde" id="qtde" tabindex="2" class="browser-default">
                  <option value="" selected>Selecione a quantidade</option>
                  <option value="10">Menos de 10 kg</option>
                  <option value="30">Entre 10 e 30 kg</option>
                  <option value="50">Entre 30 e 50 kg</option>
                  <option value="100">Entre 50 e 100 kg</option>
                  <option value="150">Mais de 100 kg</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix icon-datapicker">today</i>            
                <input type="date" name="data" id="data" tabindex="3" class="datepicker">
                <label class="datapicker-label" for="data">Quando podemos retirar?</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <label for="periodo" class="select-label">Em que período?</label>
                <select name="periodo" id="periodo" tabindex="4" class="browser-default">
                  <option value="" selected>Selecione o período</option>
                  <option value="m">Manhã</option>
                  <option value="t">Tarde</option>
                  <option value="n">Noite</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s4">
                <input name="cep" id="cep" type="text" maxlength="8" tabindex="5" value="<?php if(isset($oUsuario)){echo $oUsuario->getCep();} ?>">
                <label for="cep">CEP</label>
              </div>
              <div class="input-field col s8">
                <input name="endereco" id="endereco" type="text" maxlength="150" tabindex="6" value="<?php if(isset($oUsuario)){echo $oUsuario->getEndereco();} ?>">
                <label for="endereco">Endereço</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s4">
                <input name="numero" id="numero" type="text" maxlength="8" tabindex="7" value="<?php if(isset($oUsuario)){echo $oUsuario->getNumero();} ?>">
                <label for="numero">Número</label>
              </div>
              <div class="input-field col s8">
                <input name="complemento" id="complemento" type="text" maxlength="100" tabindex="8" value="<?php if(isset($oUsuario)){echo $oUsuario->getComplemento();} ?>">
                <label for="complemento">Complemento</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <input name="bairro" id="bairro" type="text" maxlength="65" tabindex="9" value="<?php if(isset($oUsuario)){echo $oUsuario->getBairro();} ?>">
                <label for="bairro">Bairro</label>
              </div>
              <div class="input-field col s6">
                <input name="estado" id="estado" type="text" maxlength="2" tabindex="10" value="<?php if(isset($oUsuario)){echo $oUsuario->getEstado();} ?>">
                <label for="estado">Estado</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="cidade" id="cidade" type="text" maxlength="100" tabindex="11" value="<?php if(isset($oUsuario)){echo $oUsuario->getCidade();} ?>">
                <label for="cidade">Cidade</label>
              </div>
            </div>

            <div class="row">
              <div class="response"><p></p></div>
            </div>

            <div class="row">
              <a class="waves-effect waves-light btn btn-large btn-login btn-send" tabindex="12">
              <div class="loader">
                <?php include_once('include/loader.php') ?>
              </div>

              <span class="btn-login-text">AGENDAR</span></a>
              <a href="index" class="waves-effect waves-teal btn-flat btn-large" tabindex="13">CANCELAR</a>
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
        (function ($) {

          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth(); //January is 0!
          var yyyy = today.getFullYear();

          //DATA PICKER
          $input = $('.datepicker').pickadate({
            min: new Date(yyyy,mm,dd),
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

          //BUSCA DADOS DO CEP
          $("#cep").on({
            keyup: function(e) {

              cep = $(this).val();

              if(cep.length===8){

                //FAZ REQUISIÇÃO NA API DE CEP
                $.ajax({
                  url: "http://api.postmon.com.br/v1/cep/"+cep,
                  type: "get",
                  dataType: "json"

                }).done(function(data){

                  $("#numero").val("");
                  $("#complemento").val("");
                  $("#bairro").val("");


                  $("#endereco").val(data.logradouro).addClass('active');
                  $("#bairro").val(data.bairro).addClass('active');
                  $("#estado").val(data.estado).addClass('active');
                  $("#cidade").val(data.cidade).addClass('active');

                  $("#endereco + label, #bairro + label, #estado + label, #cidade + label").addClass('active');

                  $("#numero").focus();


                })
                .fail(function(err){

                  console.log(err);

                });
              }

            },
            keydown: function(e) {

              // Allow: backspace, delete, tab, escape and enter
              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                   // Allow: Ctrl+A
                  (e.keyCode == 65 && e.ctrlKey === true) ||
                   // Allow: Ctrl+C
                  (e.keyCode == 67 && e.ctrlKey === true) ||
                   // Allow: Ctrl+X
                  (e.keyCode == 88 && e.ctrlKey === true) ||
                   // Allow: home, end, left, right
                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                       // let it happen, don't do anything
                       return;
              }
              // Ensure that it is a number and stop the keypress
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }

            }

          });

          //AVISOS
          $('.btn-send').click(function() {

             //DESATIVA BOTÃO PRA EVITAR CLIQUE DUPLO
             $('.btn-send').attr('disabled', true);
             $('.btn-send').addClass("disabled");

             //MOSTRA LOADER E ESCONDE TEXTO
             $(".loader").show();
             $(".btn-login-text").hide();

             //OCULTA DIV DE DO AVISO
             $(".response").hide();

             //SERIALIZA DADOS
             datastring = $("#formulario").serialize();
             datastring += '&data_padrao=' + data_padrao;

             //PEGA VALORES DOS CAMPOS OBRIGATÓRIOS
             var materiais = $("#materiais").val();
             var qtde = $("#qtde").val();
             var data = $("#data").val();
             var periodo = $("#periodo").val();
             var cep = $("#cep").val();
             var endereco = $("#endereco").val();
             var estado = $("#estado").val();
             var cidade = $("#cidade").val();

             //MOSTRA MENSAGENS DE AGUARDE PARA USUÁRIO
             if(materiais != "" & qtde != "" & data != "" & periodo != "" & cep != "" & endereco != "" & estado != "" & cidade != ""){

              function mostraMensagem(msg){
                message = msg;
                $(".response").removeClass("success");
                $(".response").addClass("warning");
                $(".response p").html(message);
                $(".response").show("slow");
              }

              //MOSTRA MENSAGEM DE ESPERA PARA O USUÁRIO
              mostraMensagem("Procurando cooperativas na sua região...");
             }

             //FAZ REQUISIÇÃO NO ARQUIVO PHP
             $.ajax({
                url: "include/ajax-schedule.php",
                type: "post",
                data: datastring,
                dataType: "HTML"

             }).done(function(data){

                  //ATIVA BOTÃO NOVAMENTE
                  $('.btn-send').attr('disabled', false);
                  $('.btn-send').removeClass("disabled");

                  //ESCONDE LOADER E MOSTRA TEXTO
                  $(".loader").hide();
                  $(".btn-login-text").show();

                  //VERIFICAÇÃO DOS CAMPOS DE RETORNO DO PHP
                  if(data == "materiais"){

                    returnError("material_1", "Informe os <strong>materias que possui</strong>.");

                  } else if(data == "qtde"){

                    returnError("qtde", "Informe a <strong>quantidade aproximada</strong> em kilos.");

                  } else if(data == "data"){

                    returnError("data", "Informe a <strong>data de retirada</strong>.");

                  } else if(data == "periodo"){

                    returnError("periodo", "Informe o <strong>período</strong> para retirada.");

                  } else if(data == "cep"){

                    returnError("cep", "Informe seu <strong>CEP</strong>.");

                  } else if(data == "endereco"){

                    returnError("endereco", "Informe seu <strong>endereço</strong>.");

                  } else if(data == "numero"){

                    returnError("numero", "Informe o <strong>número do seu endereço</strong>.");

                  } else if(data == "cidade"){

                    returnError("cidade", "Informe sua <strong>cidade</strong>.");

                  } else if(data == "ok"){

                    $("rect").attr("fill", "#FFF");
                    $(".loader").show();
                    $(".btn-login-text").hide();

                    $(".response").removeClass("warning");
                    $(".response").addClass("success");

                    msg = "Cooperativa mais próxima selecionada...";

                    $(".response").show("slow");
                    $(".response p").html(msg);

                    setTimeout(function(){
                      window.location = 'confirmation';
                    }, 1500); //esconde o aviso depois um tempo

                  } else {
                    console.log(data);
                    returnError("cidade", "Erro de requisição, tente novamente mais tarde.");
                  }

             })
             .fail(function(err){

                //MOSTRA MSG DE ERRO
                console.log(data, err);
                returnError("cidade", "Erro de requisição, tente novamente mais tarde.");

             });
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
