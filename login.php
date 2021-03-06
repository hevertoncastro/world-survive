<?php
//INICIA SESSÃO
@session_start();

$_SESSION["login_usuario"]["id"] = "";
$_SESSION["login_usuario"]["nome"] = "";
$_SESSION["login_usuario"]["nivel"] = "";
$_SESSION["login_usuario"]["tempo"] = "";
$_SESSION["login_usuario"]["ip"] = "";

//DESTRÓI SESSÃO
session_destroy();

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
            <li><a href="index">Home</a></li>
            <li><a href="login">Entrar</a></li>
            <li><a href="new-account">Criar conta</a></li>
            <li><a href="index#contact">Contato</a></li>
          </ul>

           <ul id="nav-mobile" class="side-nav">
            <li><a href="index">Home</a></li>
            <li><a href="login">Entrar</a></li>
            <li><a href="new-account">Criar conta</a></li>
            <li><a href="index#contact">Contato</a></li>
          </ul>
          <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
        </nav>

        <div class="section row form-login">
          <h2 class="form-title">Entre com seus dados</h2>
          <form class="col s12" role="form" onSubmit="return false;">
            <div class="row">
              <div class="input-field col s12">
                <input id="email" type="email" class="validate" tabindex="1">
                <label for="email">Email</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="password" type="password" class="validate" tabindex="2">
                <label for="password">Senha</label>
              </div>
            </div>
            <div class="row">
              <div class="response"><p></p></div>
            </div>
            <div class="row">
              <a class="waves-effect waves-light btn btn-large btn-login btn-send" tabindex="3">
              <div class="loader">
                <?php include_once('include/loader.php') ?>
              </div>

              <span class="btn-login-text">ENTRAR</span></a>
              <a href="new-account" class="waves-effect waves-teal btn-flat btn-large">CRIAR CONTA</a>
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

          var res = getUrl('res');

          var msg = "";

          if(res == "sem_permissao"){
            msg = "Efetue login para acessar esta página.";
          }

          if(res == "tempo_excedido"){
            msg = "Sessão expirada, efetue o login.";
          }

          if(res.length > 0){
            $(".response").addClass("warning");
            $(".response p").html(msg)
            $(".response").show("slow");
          }

          //FOCO EM EMAIL
          //$("#email").focus();

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
             $.post("include/ajax-login.php", { email: $("#email").val(), senha: $("#password").val()},
             function(data) {

              //ATIVA BOTÃO NOVAMENTE
              $('.btn-send').attr('disabled', false);
              $('.btn-send').removeClass("disabled");

                  //ESCONDE LOADER E MOSTRA TEXTO
                  $(".loader").hide();
                  $(".btn-login-text").show();

                  //VERIFICAÇÃO DOS CAMPOS DE RETORNO DO PHP
                  if(data == "campos_vazios"){

                    returnError("email", "Digite seu <strong>email e senha</strong>.");

                  } else if(data == "email_vazio"){

                    returnError("email", "Digite seu <strong>email</strong>.");

                  } else if(data == "email_incorreto"){

                    returnError("email", "Digite um <strong>email válido</strong>.");

                  } else if(data == "senha_vazia"){

                    returnError("password", "Digite sua <strong>senha</strong>.");

                  } else if(data == "erro"){

                    returnError("password", "Usuário e/ou senha incorretos");

                  } else if(data == "ok"){

                    $("rect").attr("fill", "#FFF");
                    $(".loader").show();
                    $(".btn-login-text").hide();

                    $(".response").removeClass("warning");
                    $(".response").addClass("success");

                    msg = "Login efetuado com sucesso! Aguarde...";

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
