<?php   
    session_start();
    if(!isset($_COOKIE['usuario'])){
        print "<script>alert('Faça login para continuar!');
                            window.location.href = \"index.php\";
                       </script>";
    }else{
        if($_COOKIE['permissao'] != "adm"){
            print "<script>alert('Tela Disponível apenas para administradores!');
                            window.location.href = \"dashboard.php\";
                       </script>";
        }else{
            $nome = $_COOKIE['nome'];
            $email = $_COOKIE['email'];
            $username = $_COOKIE['usuario'];
            $permissao = $_COOKIE['permissao'];
        }
    }

    include("../includes/mysql.php");
    $conexao = mysqli_connect($hostname, $username, $password, $database);

    function total(){
        print "teste";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gerência de Projetos</title>
        <link rel="stylesheet" href="assets/tailcss.css">
        <link rel="stylesheet" href="assets/style.css">

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
        <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
        <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <style>@import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css');</style>
    </head>

    <body class="bg-blue-100">
        <div>
            <div>
                <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
                
                <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                    <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
                
                    <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
                        <div class="flex items-center justify-center mt-8">
                            <a class="flex items-center" href="dashboard.php">
                                <svg class="h-12 w-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                                </svg>
                                
                                <span class="text-white text-1xl mx-2 font-semibold"><?php echo $nome;?></span>
                            </a>
                        </div>
                
                        <nav class="mt-10">
                            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="form_novo_proj.php">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path fill="none" d="M13.388,9.624h-3.011v-3.01c0-0.208-0.168-0.377-0.376-0.377S9.624,6.405,9.624,6.613v3.01H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h3.011v3.01c0,0.208,0.168,0.378,0.376,0.378s0.376-0.17,0.376-0.378v-3.01h3.011c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z"></path>                                </svg>
                
                                <span class="mx-3">Novo Projeto</span>
                            </a>
                            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="dashboard.php">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
                                </svg>
                
                                <span class="mx-3">Projetos</span>
                            </a>
                
                            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                                href="/ui-elements">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M10.281,1.781C5.75,1.781,2.062,5.469,2.062,10s3.688,8.219,8.219,8.219S18.5,14.531,18.5,10S14.812,1.781,10.281,1.781M10.714,2.659c3.712,0.216,6.691,3.197,6.907,6.908h-6.907V2.659z M10.281,17.354c-4.055,0-7.354-3.298-7.354-7.354c0-3.911,3.067-7.116,6.921-7.341V10c0,0.115,0.045,0.225,0.127,0.305l5.186,5.189C13.863,16.648,12.154,17.354,10.281,17.354M15.775,14.882l-4.449-4.449h6.295C17.522,12.135,16.842,13.684,15.775,14.882"></path>
                                </svg>
                
                                <span class="mx-3">Gráficos</span>
                            </a>
                
                            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                                href="/tables">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M12.546,4.6h-5.2C4.398,4.6,2,7.022,2,10c0,2.978,2.398,5.4,5.346,5.4h5.2C15.552,15.4,18,12.978,18,10C18,7.022,15.552,4.6,12.546,4.6 M12.546,14.6h-5.2C4.838,14.6,2.8,12.536,2.8,10s2.038-4.6,4.546-4.6h5.2c2.522,0,4.654,2.106,4.654,4.6S15.068,14.6,12.546,14.6 M12.562,6.2C10.488,6.2,8.8,7.904,8.8,10c0,2.096,1.688,3.8,3.763,3.8c2.115,0,3.838-1.706,3.838-3.8C16.4,7.904,14.678,6.2,12.562,6.2 M12.562,13C10.93,13,9.6,11.654,9.6,10c0-1.654,1.33-3,2.962-3C14.21,7,15.6,8.374,15.6,10S14.208,13,12.562,13"></path>
                                </svg>
                
                                <span class="mx-3">Projetos em andamento</span>
                            </a>

                            <?php if($permissao == "adm"){?>
                            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                                href="ger_user.php">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path d="M15.573,11.624c0.568-0.478,0.947-1.219,0.947-2.019c0-1.37-1.108-2.569-2.371-2.569s-2.371,1.2-2.371,2.569c0,0.8,0.379,1.542,0.946,2.019c-0.253,0.089-0.496,0.2-0.728,0.332c-0.743-0.898-1.745-1.573-2.891-1.911c0.877-0.61,1.486-1.666,1.486-2.812c0-1.79-1.479-3.359-3.162-3.359S4.269,5.443,4.269,7.233c0,1.146,0.608,2.202,1.486,2.812c-2.454,0.725-4.252,2.998-4.252,5.685c0,0.218,0.178,0.396,0.395,0.396h16.203c0.218,0,0.396-0.178,0.396-0.396C18.497,13.831,17.273,12.216,15.573,11.624 M12.568,9.605c0-0.822,0.689-1.779,1.581-1.779s1.58,0.957,1.58,1.779s-0.688,1.779-1.58,1.779S12.568,10.427,12.568,9.605 M5.06,7.233c0-1.213,1.014-2.569,2.371-2.569c1.358,0,2.371,1.355,2.371,2.569S8.789,9.802,7.431,9.802C6.073,9.802,5.06,8.447,5.06,7.233 M2.309,15.335c0.202-2.649,2.423-4.742,5.122-4.742s4.921,2.093,5.122,4.742H2.309z M13.346,15.335c-0.067-0.997-0.382-1.928-0.882-2.732c0.502-0.271,1.075-0.429,1.686-0.429c1.828,0,3.338,1.385,3.535,3.161H13.346z"></path>                    </svg>
                
                                <span class="mx-3">Gerência de Usuários</span>
                            </a>
                            <?php } ?>
                        </nav>
                    </div>
                    <div class="flex-1 flex flex-col overflow-hidden">
                        <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
                            <div class="flex items-center">
                                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                
                                <div class="relative mx-4 lg:mx-0">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                
                                    <input class="form-input w-32 sm:w-64 rounded-md pl-10 pr-4 focus:border-indigo-600" type="text"
                                        placeholder="Search">
                                </div>
                            </div>
                
                            <div class="flex items-center">
                                <div x-data="{ dropdownOpen: false }" class="relative">
                                    <button @click="dropdownOpen = ! dropdownOpen"
                                        class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                                        <img class="h-full w-full object-cover"
                                            src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=296&amp;q=80"
                                            alt="Your avatar">
                                    </button>
                
                                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                                        style="display: none;"></div>
                
                                    <div x-show="dropdownOpen"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10"
                                        style="display: none;">
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                                        <a href="index.php"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                            <div class="container mx-auto px-6 py-8">
                                <a href="?tipo=geral"><h3 class="text-gray-700 text-3xl font-medium">Usuários</h3></a>
                
                                <div class="mt-4">
                                    <div class="flex flex-wrap -mx-6">
                                        <a class="w-full px-6 sm:w-1/2 xl:w-1/3" href="?tipo=confirmacao">
                                            <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                            <div class="p-3 bg-opacity-75"><span class="material-icons">supervisor_account</span></div>
                                                <?php
                                                    $sql = "SELECT * FROM usuarios WHERE validado = 0";
                                                    $query = mysqli_query($conexao, $sql);
                                                    $tam = mysqli_num_rows($query);
                                                ?>
                                                <div class="mx-5">
                                                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $tam?></h4>
                                                    <div class="text-gray-500">Usuarios nao cadastrados</div>
                                                </div>
                                            </div>
                                        </a>
                
                                        <a class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 sm:mt-0" href="?tipo=adm">
                                            <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                            <div class="p-3 bg-opacity-75"><span class="material-icons">admin_panel_settings</span></div>
                                                <?php
                                                    $sql = "SELECT * FROM usuarios WHERE permissao = 'adm' AND validado = 1";
                                                    $query = mysqli_query($conexao, $sql);
                                                    $tam1 = mysqli_num_rows($query);
                                                ?>
                                                <div class="mx-5">
                                                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $tam1?></h4>
                                                    <div class="text-gray-500">Administradores</div>
                                                </div>
                                            </div>
                                        </a>
                
                                        <a class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0" href="?tipo=comum">
                                            <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                            <div class="p-3 bg-opacity-75"><span class="material-icons">perm_identity</span></div>
                                                <?php
                                                    $sql = "SELECT * FROM usuarios WHERE permissao != 'adm' AND validado = 1";
                                                    $query = mysqli_query($conexao, $sql);
                                                    $tam3 = mysqli_num_rows($query);
                                                ?>
                                                <div class="mx-5">
                                                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $tam3?></h4>
                                                    <div class="text-gray-500">Usuários comuns</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                
                                <div class="mt-8">
                
                                </div>
                
                                <div class="flex flex-col mt-8">
                                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                        <div
                                            class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                            <form method="POST" name="myform" id="myform" action="operador.php">

                                            <table class="min-w-full">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Name</th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Email</th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Data solocitação</th>
                                                        <th
                                                            class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Permissões</th>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                                    </tr>
                                                </thead>
                                
                                                <tbody class="bg-white">
                                                    <?php
                                                        if(isset($_GET['tipo'])){
                                                            $tipo = $_GET['tipo'];
                                                            if($tipo == "confirmacao"){
                                                                $sql = "SELECT * FROM usuarios WHERE validado = 0 ORDER BY data_insert ASC;";
                                                            }else if($tipo == "adm"){
                                                                $sql = "SELECT * FROM usuarios WHERE permissao = 'adm' AND validado = 1 ORDER BY data_insert ASC;";
                                                            }else if($tipo == "comum"){
                                                                $sql = "SELECT * FROM usuarios WHERE permissao != 'adm' AND validado = 1 ORDER BY data_insert ASC;";
                                                            }else{
                                                                $sql = "SELECT * FROM usuarios ORDER BY data_insert ASC;";
                                                            }
                                                        }else{
                                                            $sql = "SELECT * FROM usuarios ORDER BY data_insert ASC;";
                                                        }
                                                        $query = mysqli_query($conexao, $sql);
                                                        $cont = 0;
                                                        while($result = mysqli_fetch_row($query)){
                                                            $cont++;
                                                            $dia = explode("-", $result[6]);
                                                    ?>
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                                <div class="ml-4">
                                                                    <div class="text-sm leading-5 font-medium text-gray-900"><?php echo $result[1];?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                
                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                            <div class="text-sm leading-5 text-gray-900"><?php echo $result[2];?></div>
                                                        </td>
                
                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                            <div class="text-sm leading-5 text-gray-900"><?php echo $dia[2]."/".$dia[1]."/".$dia[0];?></div>
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                            <div class="text-sm leading-5 text-gray-900"><?php echo $result[5];?></div>
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                            <?php if($result[7] == 1){?>
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Cadastrado</span>
                                                            <?php }else{?>
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">À validar</span>
                                                            <?php }?>
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                                            <?php 
                                                                $id = $result[0];

                                                                $crypt = password_hash($id, PASSWORD_BCRYPT);
                                                                if($result[7] != 1){
                                                            ?>

                                                            <a href="operador.php?acao=aceitar&id=<?php echo $crypt?>&cont=<?php echo $cont?>&id1=<?php echo $id?>"  class="text-indigo-600 hover:text-indigo-900">Aceitar</a>
                                                            <a href="operador.php?acao=negar&id=<?php echo $crypt?>&cont=<?php echo $cont?>&id1=<?php echo $id?>" class="text-indigo-600 hover:text-indigo-900">Negar</a>
                                                            <?php }?>
                                                        </td>
                                                    </tr>
                                                    <?php } 
                                                    
                                                    if($cont ==0){?>
                                                        <tr>
                                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200" colspan="6">
                                                                <div class="ml-4">
                                                                    <div class="text-sm leading-5 font-medium text-gray-900">Não há cadastros a serem aceitos</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
    </body>
</html>