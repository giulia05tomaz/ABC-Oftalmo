<?php include("./includes/head.php") ?>


<div id="home-nav-bar">
    <div style="display: flex; justify-content: space-between;">
        <div class="logo-button">
            <div style="display: flex;">
                <a href="./Home.php">
                    <img class="logoHome" src="./Painel/imagens/Logo.png" />
                </a>
                <div class="p-2">
                    <h1 class="mb-0">ABC Oftalmo</h1>
                    <!-- <h4 class="mb-0" style="font-weight: 700">Oftalmo</h4> -->
                </div>
            </div>
            <button class="navbar-toggler" type="button" id="menuButton">
                <i class="fas fa-bars"></i>
            </button>
        </div>

    </div>


</div>

<div id="tela-login" class="corrige-fluid">

    <div id="retorno-ajax"></div>
    <section id="formulario-login" class="pt-5">
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
                        <a id="ForgetPassword" class="text-muted float-left">
                            Esqueceu sua senha?</a>
                        <a id="register" class="text-muted float-right">
                            Cadastre-se</a>
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



    </section>
</div>

<div class="modal fade bd-example-modal-xl" id="modalCadPaciente" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content p-4">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="namePaciente">Nome Completo</label>
                    <input type="text" class="form-control caps" id="namePaciente" maxlength="50" placeholder="nome do paciente" autocomplete="off">
                    <small id="namePacienteHelper" class="text-danger"></small>
                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <label for="telPaciente">Telefone</label>
                    <input type="text" class="form-control caps" maxlength="15" id="telPaciente" placeholder="(00)0000-0000" autocomplete="off">

                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <label for="celularPaciente">Celular</label>
                    <input type="text" class="form-control caps" maxlength="15" id="celularPaciente" placeholder="(00)00000-0000" autocomplete="off">

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="CpfPaciente">CPF</label>
                    <input type="text" class="form-control caps" id="CpfPaciente" maxlength="14" placeholder="00.000.000-0" autocomplete="off">

                </div>
                <div class="form-group col-md-2">
                    <label for="RgPaciente">RG</label>
                    <input type="text" class="form-control caps" id="RgPaciente" maxlength="14" placeholder="000.000.000-00" autocomplete="off">

                </div>
                <div class="form-group col-md-5">
                    <label for="emailPaciente">Email</label>
                    <input type="text" class="form-control caps" id="emailPaciente" placeholder="Insira um email" maxlength="30" autocomplete="off">
                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <label for="dataNasciPaciente">Data de nascimento</label>
                    <input type="date" maxlength="5" class="form-control datefield" id="dataNasciPaciente">
                    <small id="dtAdmisTrHelpCad" class="text-danger"></small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="CepPaciente">CEP</label>
                    <input type="text" class="form-control caps" id="CepPaciente" maxlength="14" placeholder="00000-000" autocomplete="off">

                </div>

                <div class="form-group col-md-6">
                    <label for="EndPaciente">Endereço</label>
                    <input type="text" class="form-control caps" id="EndPaciente" maxlength="14" placeholder="Ex: Rua das flores" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="BairroPaciente">Bairro</label>
                    <input type="text" class="form-control caps" id="BairroPaciente" maxlength="14" placeholder="Ex: Jardins" autocomplete="off">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="cidadePaciente">Cidade</label>
                    <input type="text" class="form-control caps" id="cidadePaciente" maxlength="14" placeholder="Ex: São paulo" autocomplete="off">

                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <label for="EstadoPaciente">Estado</label>
                    <input type="text" class="form-control caps" id="EstadoPaciente" maxlength="14" placeholder="Ex:São paulo" autocomplete="off">
                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <label for="NumeroPaciente">Numero</label>
                    <input type="text" class="form-control caps" id="NumeroPaciente" maxlength="14" placeholder="Ex: 123" autocomplete="off">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="NumeroPaciente">Convênio</label>
                    <select class="custom-select selectPac" name="Eventos2Modal" id="isConvenio">
                        <option value="">Selecione </option>
                        <option value="SIM">SIM</option>
                        <option value="NAO" selected>NÃO</option>

                    </select>

                </div>
                <div class="form-group col-md-3"></div>
                <div class="form-group col-md-6">
                    <label for="nomeConvenio">Nome do convênio</label>
                    <input type="text" class="form-control caps" id="nomeConvenio" autocomplete="off">

                </div>


            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control caps" id="password" maxlength="14" autocomplete="off">

                </div>
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-5">
                    <label for="Confirmpassword">Confirmar senha</label>
                    <input type="password" class="form-control caps" id="Confirmpassword" maxlength="14" autocomplete="off">
                </div>
                <div class="form-group col-md-1"></div>

            </div>

            <div class="modal-footer">

                <div class="container-fluid">
                    <div class="row">
                        <div class="d-flex text-left col-md-6   justify-content-start" id="footerTrab"></div>
                        <div class="d-flex text-right col-md-6 col-12 col-sm-12 justify-content-end">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                            <button type="button" class="btn btn-darkblue" id="ConfCadTrab" onclick="gravarPaciente()">CADASTRAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include("./includes/imports.php") ?>
<?php include("./Painel/includes/messageModal.php") ?>
<script src="./js/Login.js"></script>