<?php
//INICIA SESSÃO
@session_start();

// $_SESSION["login_usuario"]["id"] = "";
// $_SESSION["login_usuario"]["nome"] = "";
// $_SESSION["login_usuario"]["nivel"] = "";
// $_SESSION["login_usuario"]["tempo"] = "";
// $_SESSION["login_usuario"]["ip"] = "";

// //DESTRÓI SESSÃO
// session_destroy();

//PEGA AÇÃO POR GET
$res = isset($_GET['res']) ? $_GET['res'] : NULL;
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="img/favicon.ico">

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
            <li><a href="index">Home</a></li>
            <li><a href="login">Entrar</a></li>
            <li><a href="new-account">Criar conta</a></li>
            <li><a href="contact">Contato</a></li>
          </ul>

           <ul id="nav-mobile" class="side-nav">
            <li><a href="index">Home</a></li>
            <li><a href="login">Entrar</a></li>
            <li><a href="new-account">Criar conta</a></li>
            <li><a href="contact">Contato</a></li>
          </ul>
          <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
        </nav>

        <div class="section row form-login">
          <h2 class="form-title">Agendamento realizado!</h2>
          <form class="col s12" role="form" onSubmit="return false;">
            
            <div class="row">
              <p>A coleta será feita pela cooperativa xxxxxxxxx<br>
              Data da coleta: 00/00/0000<br>
              Período: xxxxxx.<br>
              Telefone de contato: (11) 98765-4321</p>
            </div>
            <div class="row">
              <a class="waves-effect waves-light btn btn-large btn-login btn-send" tabindex="4">
              <div class="loader">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                   width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                  <rect x="0" y="13" width="4" height="5" fill="#5FA945">
                    <animate attributeName="height" attributeType="XML"
                      values="5;21;5" 
                      begin="0s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                      values="13; 5; 13"
                      begin="0s" dur="0.6s" repeatCount="indefinite" />
                  </rect>
                  <rect x="10" y="13" width="4" height="5" fill="#5FA945">
                    <animate attributeName="height" attributeType="XML"
                      values="5;21;5" 
                      begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                      values="13; 5; 13"
                      begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                  </rect>
                  <rect x="20" y="13" width="4" height="5" fill="#5FA945">
                    <animate attributeName="height" attributeType="XML"
                      values="5;21;5" 
                      begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                      values="13; 5; 13"
                      begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                  </rect>
                </svg>
              </div>

              <span class="btn-login-text">COMPARTILHAR</span></a>
              <a href="logoff" class="waves-effect waves-teal btn-flat btn-large">SAIR</a>
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

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
        /*(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X','auto');ga('send','pageview');*/

        (function ($) {

          //FOCUS EM USUÁRIO
          //$("#name").focus();

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

             //FAZ REQUISIÇÃO NO ARQUIVO PHP ENVIANDO OS DADOS POR POST A PARTIR DO ID DE CADA UM
             $.post("include/ajax-new-account.php", { name: $("#name").val(), email: $("#email").val(), senha: $("#password").val()},
             function(data) {

              //ATIVA BOTÃO NOVAMENTE
              $('.btn-send').attr('disabled', false);
              $('.btn-send').removeClass("disabled");   

                  //ESCONDE LOADER E MOSTRA TEXTO
                  $(".loader").hide();
                  $(".btn-login-text").show();

                  //VERIFICAÇÃO DOS CAMPOS DE RETORNO DO PHP
                  if(data == "campos_vazios"){

                    returnError("name", "Digite seu <strong>nome, email e senha</strong>.");

                  } else if(data == "nome_vazio"){

                    returnError("name", "Digite seu <strong>nome</strong>.");

                  } else if(data == "email_vazio"){

                    returnError("email", "Digite seu <strong>email</strong>.");

                  } else if(data == "email_incorreto"){

                    returnError("email", "Digite um <strong>email válido</strong>.");

                  } else if(data == "senha_vazia"){

                    returnError("password", "Digite sua <strong>senha</strong>.");

                  } else if(data == "senha_curta"){

                    returnError("password", "Sua senha deve ter no mínimo <strong>6 caracteres</strong>.");

                  } else if(data == "usuario_existe"){

                    returnError("name", "Você <strong>já possui um cadastro</strong> no site.");

                  } else if(data == "erro"){

                    returnError("password", "Usuário e/ou senha incorretos");

                  } else if(data == "ok"){

                    $(".response").removeClass("warning");
                    $(".response").addClass("success");

                    msg = "Usuário cadastrado com sucesso! Aguarde...";

                    $(".response").show("slow");
                    $(".response p").html(msg);

                    setTimeout(function(){
                      window.location = 'schedule';
                    }, 1500); //esconde o aviso depois um tempo

                  } else {
                    console.log(data);
                  }

             });
          });

        }(jQuery));
        </script>
    </body>
</html>
