<?php include('./includes/head.php') ?>

<body id="bodyHomepac ">
    <ul class="nav " id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" href="./Inicio.php" role="tab" aria-controls="home" aria-selected="true">Início</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" href="./Historico.php" role="tab" aria-controls="profile" aria-selected="false">Histórico</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" href="" role="tab" aria-controls="contact" aria-selected="false">Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="logout" role="tab" aria-controls="contact" data-toggle="modal" data-target="#modalExit" aria-selected="false">Sair</a>
        </li>
    </ul>
    <div>
        <h1 class="text-center">Perfil</h1>
        <div class="p-3 pb-5 mt-4" style="width: 50%; margin: 0 auto;background-color: #f2f5ff;">
            <div class=" mt-2 p-3">
                <div id="listInicio">
                    <h3 class="text-center">Meu dados</h3>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Nome</label>
                            <input type="text" id="namePac" class="form-control" autocomplete="off" placeholder="Digite seu nome">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Email</label>
                            <input type="text" id="emailPac" class="form-control" autocomplete="off" placeholder="Digite seu email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Telefone</label>
                            <input type="text" id="telPaciente" class="form-control" maxlength="15" autocomplete="off" placeholder="Digite seu telefone">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Cep</label>
                            <input type="text" id="CepPaciente" class="form-control" autocomplete="off" placeholder="Digite seu cep">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Possui convenio</label>
                            <select class="custom-select selectAgd" name="Eventos2Modal" id="isConvenio">
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NAO">NAO</option>


                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-lg-3 col-sm-12">
                            <!-- <i class="fa fa-person fa-3x"></i> -->
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="nomeConvenio">Nome convenio</label>
                            <input disabled type="text" id="nameConvenio" class="form-control" autocomplete="off" placeholder="Nome do convenio">
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-12 col-lg-12  text-center">
                            <button type="button" class="btn btn-darkblue" id="psePaciente" onclick="saveAlterar()">Salvar</button>
                            <div class="row justify-content-center">
                                <small id="psePacienteHelper" class="text-danger"></small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
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
</body>

</html>
<?php include('./includes/imports.php') ?>
<?php include("./Painel/includes/messageModal.php") ?>
<script src="./js/Profile.js"></script>

<script>
    function logout() {
        localStorage.clear()
        window.location.replace('./Login.php')

    }
</script>