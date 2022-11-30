<?php
include("./includes/menu.php");
if (session_status() !== PHP_SESSION_ACTIVE) {


    if (isset($_SESSION['nvAcesso'])) {
        $nvAcesso =  $_SESSION['nvAcesso'];



        if ($nvAcesso > 2) {
            header('Location: ./Home.php'); //Retorna a Tela de login
        }
    } else {
        header('Location: ./Home.php');
    }
}

include("./includes/head.php");

?>

<body class="mt-5">
    <div class="containerGrid pt-5">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu">Usuários </h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">

                <button type="button" class="btn  float-right mr-2 btn-custom-x btn-darkblue" title="Novo agendamento" data-toggle="modal" data-target="#modalCadUsuarios">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button>
                <table id="listasJqueryUsuarios" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 7vw;">Nome </th>
                            <th class="th-sm" style="width: 5vw;">Email</th>
                            <th class="th-sm" style="width: 7vw;">Nível de acesso</th>
                            <th class="th-sm" style="width: 7vw;">Status</th>
                            <th class="th-sm" style="width: 7vw;">Ações</th>


                        </tr>
                    </thead>
                    <tbody id="gridUsuarios"></tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalCadUsuarios" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content p-4">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nameLogin">Login do usuário</label>
                        <input type="text" class="form-control" id="nameLogin" maxlength="70" placeholder="Login do usuario" autocomplete="off">
                        <small id="nameLoginSpan" class="text-danger"></small>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="passwordUser">Senha</label>
                        <input type="text" class="form-control" id="passwordUser" maxlength="70" autocomplete="off">
                        <small id="passwordUserSpan" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="celularPaciente">Gerar senha </label>
                        <button onclick="generatePassword()"> Gerar senha</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nameUser">Nome </label>
                        <input type="text" class="form-control " id="nameUser" placeholder="Nome do usuario" maxlength="70" autocomplete="off">
                        <small id="nameUserSpan" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="emailUser">Email</label>
                        <input type="text" class="form-control " id="emailUser" placeholder="Email do usuario" maxlength="50" autocomplete="off">
                        <small id="emailUserSpan" class="text-danger"></small>
                    </div>


                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="statusUser">Status</label>
                        <select class="custom-select selectUser" id="statusUser">
                            <option value="">Status do usuário</option>
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>


                        </select>
                        <small id="statusUserSpan" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nvUser">Nível</label>
                        <select class="custom-select selectUser" id="nvUser">
                            <option value="">Nível de acesso</option>
                            <option value="2">Administrativo</option>
                            <option value="3">Atendente</option>
                            <option value="1">Médico</option>

                        </select>
                        <small id="nvUserSpan" class="text-danger"></small>
                    </div>

                </div>

                <div class="form-row" id="rowDesblock">
                    <div class="form-group col-md-12 col-lg-12  text-center">
                        <button type="button" class="btn btn-darkblue" id="dsbUser" onclick="desblockUser()">Desbloquear usuário</button>

                    </div>
                </div>

                <div class="modal-footer">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="d-flex text-left col-md-6   justify-content-start" id="footerTrab"></div>
                            <div class="d-flex text-right col-md-6 col-12 col-sm-12 justify-content-end">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                <button type="button" class="btn btn-darkblue" onclick="gravaUsuarios()" id="cadUser">CADASTRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal fade" id="deletaPaciente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notify  modal-danger" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead text-center ">Atenção</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-bell fa-4x animated rotateIn mb-4"></i>
                        <p>Deseja realmente deletar este registro ?</p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">

                    <a type="button" class="btn  waves-effect btn-outline-danger" onclick="deletaUsuarios()" data-dismiss="modal">Ok</a>
                    <a type="button" class="btn  waves-effect btn-darkblue" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
</body>
<?php include("./includes/imports.php") ?>
<?php include("./includes/messageModal.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./js/toast.js"></script>
<script src="./js/Usuarios.js"></script>