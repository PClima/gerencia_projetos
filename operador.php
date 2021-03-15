<?php
    session_start();
    include("../includes/mysql.php");
    $conexao = mysqli_connect($hostname, $username, $password, $database);

    if(isset($_POST['acao'])){
        $acao = $_POST['acao'];
    }else{
        $acao = $_GET['acao'];
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

            $sql = "UPDATE projetos SET tipo = '$tipo' AND descricao = '$descricao' AND categoria = '$categoria' AND prioridade = '$prioridade' AND justificativa = '$justificativa' AND fim = '$fim' AND receita = '$receita' AND cliente = '$cliente' WHERE id = '$id'";
            print "$sql";
            /*$query = mysqli_query($conexao, $sql);

            if($query){
                print "<script>alert('Projeto Alterado com sucesso!')
                            window.location.href = \"dashboard.php\";
                       </script>";
            }else{
                mysqli_query($conexao, "rollback;");
                print "<script>alert('Erro ao alterar projeto!')
                            window.location.href = \"form_projeto.php?id=$id\";
                       </script>";
            }*/
            break;
    }
?>