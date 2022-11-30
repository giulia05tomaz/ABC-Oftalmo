<?php include("./includes/head.php") ?>



<header class="corrige-fluid">

</header>

<div id="tela-login" class="corrige-fluid">
    <div id="retorno-ajax"></div>
    <section id="formulario-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- <div class="col-3">
                    <img src="./imagens/icone.png" alt="Logo B2P" class="w-100">
                </div> -->
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4" id="caixa-login">
                    <h4>Login</h4>
                    <!-- <form> -->
                    <div>
                        <label for="LoginForm">Usuário</label>
                        <input type="text" id="usuarioForm" class="form-control" name="userLogin" autocomplete="off" placeholder="Digite seu usuário">
                    </div>
                    <br>
                    <div>
                        <label for="LoginForm">Senha</label>
                        <input type="password" id="senhaForm" class="form-control" name="senhaLogin" placeholder="Digite sua senha">
                    </div>
                    <br>
                    <!-- Sign in button -->
                    <button class="btn btn-login btn-block my-2" type="button" onclick="login()">Entrar</button>

                    <!-- Forget password -->
                    <div class="w-100">
                        <a id="ForgetPassword" class="text-muted float-right">
                            Esqueceu sua senha?</a>
                    </div>
                    <!-- data-toggle="modal" data-target="#basicExampleModal" -->
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!-- Modal Recuperar Senha -->
        <div class="modal fade left" id="ModalEsqueciSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify" id="recSenha" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header modal-darkblue">
                        <p class="heading font-weight-bold">Recupere sua senha</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <!--Body-->
                    <div class="modal-body">

                        <div>
                            <label for="RecEmail">E-mail</label>
                            <input type="email" id="RecEmail" class="form-control" placeholder="Digite seu E-mail...">
                        </div>
                        <br>
                        <div class="text-center">
                            <!-- Sign in button -->
                            <button class="btn btn-darkblue" type="submit" onclick="recoverPass()" id="enviarInfos">enviar</button>
                            <!-- <a href="">Esqueceu sua senha?</a> -->
                        </div>

                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->
        <!-- Modal Usuário e Senha Incorretos -->
        <div class="modal fade left" id="ModalInvalido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading font-weight-bold">Aviso!</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>Usuário e/ou Senha inválidos</strong></p>
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-warning" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal Erro na Rede -->
        <div class="modal fade left" id="ModalErroUserSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading font-weight-bold">Erro!</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>Favor preencher corretamente todos os campos</strong></p>
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-warning" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal Erro na Rede -->
        <div class="modal fade left" id="ModalSuccessSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-notify modal-sucess" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading font-weight-bold">O e-mail foi enviado!</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>Confira, caso não tenha chego refaça o processo.</strong></p>
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-darkblue" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal falha -->
        <div class="modal fade" id="erro_modal_geral" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-notify modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="heading lead">Falha ao executar ação</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-times fa-4x animated rotateIn"></i>
                            <p id="mensagem_de_erro"></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Ok</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <?php include("./includes/imports.php") ?>
    <?php include("./includes/messageModal.php") ?>
    <script src="./js/Login.js"></script>