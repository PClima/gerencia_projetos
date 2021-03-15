<?php
    session_start();
    if(isset($_COOKIE['usuario'])){
        setcookie('nome', null, -1);
        setcookie('email', null, -1);
        setcookie('usuario', null, -1);
        setcookie('permissao', null, -1);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="assets/tailcss.css">
        <link rel="stylesheet" href="assets/style.css">

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

        <script>
            function f_acao(valor){
                with(document.myform){
                    acao.value = valor;
                }
            }
        </script>

        <style>@import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css');</style>
    </head>

    <body>
        <div class="bg-blue-100 h-screen w-screen">
            <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
                <div class="flex rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0" style="height: 700px">
                    <div class="flex flex-col w-full md:w-1/2 p-4">
                        <div class="flex flex-col flex-1 justify-center mb-8">
                            <h1 class="text-4xl text-center font-thin">Bem Vindo</h1>
                            <div class="w-full mt-4">
                                <form class="form-horizontal w-3/4 mx-auto" method="POST" name="myform" id="myform" action="operador.php">
                                    <div class="flex flex-col mt-4">
                                        <input id="user" type="text" class="flex-grow h-8 px-2 border rounded border-grey-400" name="user" value="" placeholder="Username">
                                    </div>
                                    <div class="flex flex-col mt-4">
                                        <input id="password" type="password" class="flex-grow h-8 px-2 rounded border border-grey-400" name="password" required placeholder="Password">
                                    </div>
                                    <div class="flex flex-col mt-8">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded" onclick="f_acao('logar')">
                                            Login
                                        </button>
                                    </div>
                                    <input type="hidden" id="acao" name="acao" value="x">

                                </form>
                                <div class="text-center mt-4">
                                    <a class="no-underline hover:underline text-blue-dark text-xs" href="forgot_password.php">
                                        Forgot Your Password?
                                    </a>
                                </div>
                                <div class="text-center mt-4">
                                    <a class="no-underline hover:underline text-blue-dark text-xs" href="cadastro.php">
                                        Ainda não é cadastrado? Cadastre-se já!
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block md:w-1/2 rounded-r-lg" style="background: url('https://images.unsplash.com/photo-1515965885361-f1e0095517ea?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=3300&q=80'); background-size: cover; background-position: center center;"></div>
                </div>
            </div>
        </div>
    </body>
</html>