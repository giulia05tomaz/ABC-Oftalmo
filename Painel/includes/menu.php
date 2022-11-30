<?php
$nameUser = '';
if (session_status() !== PHP_SESSION_ACTIVE) {
    date_default_timezone_set('America/Sao_Paulo');
    session_start();

    if (isset($_SESSION['email'])) {
        $Email =   $_SESSION['email'];
        $nameUser =   $_SESSION['nomeUsuario'];


        $token_padrao = MD5(MD5('abcoftalmo') .  $Email . date("dmy"));

        if ($_SESSION['token'] !== $token_padrao) {
            header('Location: ./Login.php'); //Retorna a Tela de login
        }
    } else {
        header('Location: ./Login.php');
    }
}

?>

<style>
    ul.dark_menu {
        list-style: none;
        padding: 5px 1px;
        font-family: 'Segoe UI Light', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
        font-weight: 200;
        font-size: 16px;
        letter-spacing: 0.01em;
        font-smooth: always;
        color: #000000;
        line-height: 15px;
        margin: auto;
        width: 1018px;
        position: relative;
        background: #2B5797;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu:after {
        content: "";
        clear: both;
        display: block;
        overflow: hidden;
        visibility: hidden;
        width: 0;
        height: 0;
    }

    ul.dark_menu li {
        float: left;
        position: relative;
        margin: 1px;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu li a,
    ul.dark_menu li a:link {
        color: #fafafa;
        text-decoration: none;
        display: block;
        padding: 8px 26px;
        -webkit-transition: all 0.2s ease;
        -moz-transition: all 0.2s ease;
        -o-transition: all 0.2s ease;
        -ms-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu li a:hover {
        color: #fafafa;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu li a.selected {
        border-right: 1px solid #ddd;
        text-transform: uppercase;
        margin-left: 10px;
    }

    ul.dark_menu li a.selected,
    ul.dark_menu li a:active {
        color: #fafafa;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    ul.dark_menu li ul {
        display: none;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu li ul:before {
        content: " ";
        position: absolute;
        display: block;
        z-index: 1500;
        left: 0;
        top: -10px;
        height: 10px;
        width: 100%;
    }

    ul.dark_menu li ul {
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        top: 55px;
    }

    ul.dark_menu li:hover ul {
        position: absolute;
        display: block;
        z-index: 1000;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        left: 0;
        border-radius: 0px 0px 5px 5px;
        top: 37px;
        padding: 5px 0;
        list-style: none;
        background: #fff;
    }

    /* Blog johanes djogzs.blogspot.com */
    ul.dark_menu li ul li {
        float: none;
        margin: 0px;
    }

    ul.dark_menu li ul li:first-child {
        margin: 0px;
        border-top: 0 none;
    }

    ul.dark_menu li ul li:last-child {
        border-bottom: 0 none;
    }


    ul.dark_menu li ul li a,
    ul.dark_menu li ul li a:link {
        color: #222;
        display: block;
        background: transparent none;
        padding: 10px 25px 10px 25px;
        white-space: nowrap;
    }

    ul.dark_menu li ul li a:hover {
        background: #2B5797;
        -moz-transition: all 0.1s ease-in-out;
        color: #fff;
        -webkit-transition: all 0.1s ease-in-out;
    }

    /* Blog johanes djogzs.blogspot.com */
    .menujohanes {
        position: relative;
    }


    #main4,
    #main5,
    #main6 {
        width: 303px;
        list-style-type: none;
        float: left;
        margin: 10px;
    }

    .main3 {
        width: 305px;
        list-style-type: none;
        padding-top: 10px;
        float: left;
    }



    li#sub ul {
        display: none;
        position: absolute;
        left: 100%;
        top: 0;
    }

    li#sub:hover ul {
        display: block;
    }

    .fixed-top {
        background-color: #2B5797;

    }

    @media (max-width: 800px) {
        ul.dark_menu {
            display: grid;
        }

    }
</style>
<header>
    <div id="preloader">
        <div class="inner">
            <!-- HTML DA ANIMAÇÃO MUITO LOUCA DO SEU PRELOADER! -->
            <div class="bolas">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div class="container" id="nav-container">
        <!-- add essa class -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light ">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-links" aria-controls="navbar-links" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-start" id="navbar-links">
                <div class="navbar-nav">
                    <div class='menujohanes'>
                        <ul class='dark_menu'>
                            <li data-role='dropdown'>
                                <a onclick="changePage('Home.php')" class='selected'>
                                    Home
                                </a>

                            </li>

                            <li data-role='dropdown'>
                                <a class='selected'>
                                    Cadastro
                                </a>
                                <ul>

                                    <li>
                                        <a onclick="changePage('Pacientes.php')">
                                            Pacientes
                                        </a>
                                    </li>
                                    <?php
                                    if (isset($_SESSION['nvAcesso']) && $_SESSION['nvAcesso'] < 3) {

                                    ?>
                                        <li>
                                            <a onclick="changePage('Usuarios.php')">
                                                Usuários
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                    <li>
                                        <a onclick="changePage('Procedimentos.php')">
                                            Procedimentos
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li data-role='dropdown'>
                                <a class='selected'>
                                    Agendamentos
                                </a>
                                <ul>

                                    <li>
                                        <a onclick="changePage('Agendamentos.php?room=1')">
                                            Sala 123
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="changePage('Agendamentos.php?room=2')">
                                            Sala 127
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li data-role='dropdown'>
                                <a onclick="changePage('AgendamentosRel.php')" class='selected'>
                                    Novos Agendamentos
                                    <span id="numberAgendas" class="text-danger">


                                    </span>
                                </a>

                            </li>
                            <li data-role='dropdown'>
                                <a class='selected'>
                                    ADM
                                </a>
                                <ul>

                                    <li id='sub'>
                                        <a>
                                            Recibos
                                        </a>
                                        <ul>
                                            <li>
                                                <a onclick="changePage('Recibos.php?room=1')">
                                                    Sala 123
                                                </a>
                                            </li>
                                            <li>
                                                <a onclick="changePage('Recibos.php?room=2')">
                                                    Sala 127
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li id='sub'>
                                        <a>
                                            Fechamento
                                        </a>
                                        <ul>
                                            <li>
                                                <a onclick="changePage('Fechamento.php?room=1')">
                                                    Sala 123
                                                </a>
                                            </li>
                                            <li>
                                                <a onclick="changePage('Fechamento.php?room=2')">
                                                    Sala 127
                                                </a>
                                            </li>
                                        </ul>

                                    </li>


                                </ul>
                            </li>
                            <li data-role='dropdown'>
                                <a class='selected' data-toggle="modal" data-target="#modalExit">
                                    Sair
                                </a>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div>
                <a class="navbar-brand text-white" href="#">
                    <?php


                    echo  $_SESSION['nomeUsuario'];

                    ?>
                </a>
                <i class="fas fa-user-circle fa-3x" style="color: white;"></i>
            </div>
        </nav>
    </div>
    <div class="modal fade" id="modalExit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sair</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente sair do sistema ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="logout()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="./js/Logout.js"></script>
<script>
    function changePage(page) {
        if (window.location.pathname.includes(page)) {
            return
        }
        window.location = './' + page
    }
</script>