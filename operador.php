<?php
    session_start();
    
    include("../includes/mysql.php");
    $conexao = mysqli_connect($hostname, $username, $password, $database);

    if(isset($_POST['acao'])){
        $acao = $_POST['acao'];
    }else{
        $acao = $_GET['acao'];
    }

    function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos
      
          if ($maiusculas){
                // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
                $senha .= str_shuffle($ma);
          }
    
          if ($minusculas){
              // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($mi);
          }
      
          if ($numeros){
              // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($nu);
          }
      
          if ($simbolos){
              // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($si);
          }
      
          // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
          return substr(str_shuffle($senha),0,$tamanho);
      }
    

    switch("$acao"){
        case "cadastrar":
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $user = $_POST['user'];
            $password = $_POST['password'];
            $permissao = $_POST['permissao'];
            $data = date("Y-m-d");

            $sql = "INSERT INTO usuarios values('', '$nome', '$email', '$user', PASSWORD('$password'), '$permissao', '$data', 0);";
            $query = mysqli_query($conexao, $sql);

            if($query){
                print "<script>alert('Cadastro solicitado!')
                            window.location.href = \"index.php\";
                       </script>";
            }else{
                mysqli_query($conexao, "rollback;");
                print "<script>alert('Cadastro solicitado!')
                            window.location.href = \"index.php\";
                       </script>";
            }
        break;

        case "logar":
            $user = $_POST['user'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM usuarios WHERE senha = PASSWORD('$password') AND usuario = '$user' AND validado = 1";
            $query = mysqli_query($conexao, $sql);
            $tam = mysqli_num_rows($query);

            if($tam != 0){
                $result = mysqli_fetch_row($query);

                setcookie("nome", $result[1]);
                setcookie("email", $result[2]);
                setcookie("usuario", $result[3]);
                setcookie("permissao", $result[5]);
                setcookie("id", $result[0]);

                print "<script>
                            window.location.href = \"dashboard.php\";
                       </script>";
            }else{
                session_destroy();
                print "<script>alert('Usuario e/ou senha incorretos!');
                            window.location.href = \"index.php\";
                       </script>";
            }
        break;

        case "aceitar":
            $cont = $_GET['cont'];
            $password = $_GET['id'];
            $id = $_GET['id1'];

            if(password_verify($id, $password)){
                if($_COOKIE['permissao'] != "adm"){
                    print "<script>alert('Ação permitida apenas para administradores!');
                            window.location.href = \"dashboard.php\";
                       </script>";
                }else{
                    $sql = "UPDATE usuarios SET validado = 1 WHERE id = '$id'";
                    $query = mysqli_query($conexao, $sql);

                    if($query){
                        print "<script>alert('Usuário cadastrado com sucesso!');
                            window.location.href = \"ger_user.php\";
                       </script>";
                    }else{
                        mysqli_query($conexao, 'rollback;');
                        print "<script>alert('Erro ao cadastrar usuário!');
                            window.location.href = \"ger_user.php\";
                       </script>";
                    }
                }
            }else{
                print "<script>alert('Parâmetros inválidos!');
                            window.location.href = \"dashboard.php\";
                       </script>";
            }
        break;

        case "negar":
            $cont = $_GET['cont'];
            $password = $_GET['id'];
            $id = $_GET['id1'];

            if(password_verify($id, $password)){
                if($_COOKIE['permissao'] != "adm"){
                    print "<script>alert('Ação permitida apenas para administradores!');
                            window.location.href = \"dashboard.php\";
                       </script>";
                }else{
                    $sql = "DELETE FROM usuarios WHERE id = '$id'";
                    $query = mysqli_query($conexao, $sql);

                    if($query){
                        print "<script>alert('Usuário negado com sucesso!');
                            window.location.href = \"ger_user.php\";
                       </script>";
                    }else{
                        mysqli_query($conexao, 'rollback;');
                        print "<script>alert('Erro ao negar cadastro!');
                            window.location.href = \"ger_user.php\";
                       </script>";
                    }
                }
            }else{
                print "<script>alert('Parâmetros inválidos!');
                            window.location.href = \"dashboard.php\";
                       </script>";
            }
        break;
        
        case "cadastrar_proj":
            $titulo = $_POST['titulo'];
            $tipo = $_POST['tipo'];
            $descricao = $_POST['desc'];
            $categoria = $_POST['categoria'];
            $prioridade = $_POST['prioridade'];
            $justificativa = $_POST['jus'];
            $inicio = $_POST['inicio'];
            $prazo = $_POST['prazo'];
            $receita = $_POST['receita'];
            $repositorio = $_POST['git'];
            $trello = $_POST['trello'];
            $link = $_POST['link'];
            $reponsavel = $_COOKIE['nome'];
            $cliente = $_POST['cliente'];

            
            $sql = "INSERT INTO projetos values('', '$titulo', '$tipo', '$descricao', '$categoria', '$prioridade', '$justificativa', '$inicio', '$prazo', '', '$receita', '$repositorio', '$trello', '$link', '$reponsavel', '$cliente');";
            
            $query = mysqli_query($conexao, $sql);

            if($query){
                print "<script>alert('Projeto cadastrado!')
                            window.location.href = \"dashboard.php\";
                       </script>";
            }else{
                mysqli_query($conexao, "rollback;");
                print "<script>alert('Erro ao cadastrar projeto novo!')
                            window.location.href = \"form_novo_proj.php\";
                       </script>";
            }
            break;

        case "alterar_proj":

            $id = $_POST['id_'];
            $tipo = $_POST['tipo'];
            $descricao = $_POST['desc'];
            $categoria = $_POST['categoria'];
            $prioridade = $_POST['prioridade'];
            $justificativa = $_POST['jus'];
            $fim = $_POST['fim'];
            $receita = $_POST['receita'];
            $cliente = $_POST['cliente'];

            $sql = "UPDATE projetos SET tipo = '$tipo', descricao = '$descricao', categoria = '$categoria', prioridade = '$prioridade', justificativa = '$justificativa', fim = '$fim', receita = '$receita', cliente = '$cliente' WHERE id = '$id'";
            
            $query = mysqli_query($conexao, $sql);

            if($query){
                print "<script>alert('Projeto Alterado com sucesso!')
                            window.location.href = \"dashboard.php\";
                       </script>";
            }else{
                mysqli_query($conexao, "rollback;");
                print "<script>alert('Erro ao alterar projeto!')
                            window.location.href = \"form_projeto.php?id=$id\";
                       </script>";
            }
            break;

        case "atualiza_user":
            $senha = $_POST['senha'];
            $id = $_POST['id_'];

            $sql = "UPDATE usuarios SET senha = PASSWORD('$senha') WHERE id='$id'";
            $query = mysqli_query($conexao, $sql);

            if($query){
                print "<script>alert('Usuario atualizado com sucesso!')
                            window.location.href = \"dashboard.php\";
                       </script>";
            }else{
                mysqli_query($conexao, "rollback;");
                print "<script>alert('Erro ao atualizar usuario!')
                            window.location.href = \"profile.php\";
                       </script>";
            }
            break;
        
        case "forgot_password":
            $user = $_POST['user'];

            $sql = "SELECT * FROM usuarios WHERE usuario='$user'";
            $query = mysqli_query($conexao, $sql);

            if($query){
                $result = mysqli_fetch_row($query);
                $nova_senha = gerar_senha(8, 1, 5, 1, 1);

                $sql = "UPDATE usuarios SET senha=PASSWORD('$nova_senha') WHERE usuario='$user'";
                $query = mysqli_query($conexao, $sql);
                
                if($query){
                    $to = $result[2];
                    $subject = "Solicitação de alteração de senha - Gerencia de Projetos";
                    $message = "Você solicitou a alteração de senha no sistema de gerencia de projetos.\nPara acesso no sistema novamente, utilize a senha: $nova_senha";
                    $headers = "From: cordeirolima.pedro@gmail.com\r\n";
                    
                    if (mail($to, $subject, $message, $headers)) {
                        print "<script>alert('Senha alterada com sucesso!')
                            window.location.href = \"index.php\";
                        </script>";
                     } else {
                        mysqli_query($conexao, "rollback;");
                        print "<script>alert('Erro ao atualizar senha!')
                                window.location.href = \"index.php\";
                        </script>";
                     }
                }else{
                    mysqli_query($conexao, "rollback;");
                    print "<script>alert('Erro ao atualizar senha!')
                            window.location.href = \"index.php\";
                       </script>";
                }
                

                
                
            }else{
                print "<script>alert('Usuario não encontrado!')
                            window.location.href = \"index.php\";
                       </script>";
            }

            break;


        
    }
?>