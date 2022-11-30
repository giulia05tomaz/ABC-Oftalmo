<?php include('./includes/head.php') ?>

<body id="bodyHomepac ">
    <ul class="nav " id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" href="" role="tab" aria-controls="home" aria-selected="true">Início</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" href="./Historico.php" role="tab" aria-controls="profile" aria-selected="false">Histórico</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" href="./Profile.php" role="tab" aria-controls="contact" aria-selected="false">Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="logout" role="tab" aria-controls="contact" data-toggle="modal" data-target="#modalExit" aria-selected="false">Sair</a>
        </li>
    </ul>
    <div>
        <h1 class="text-center">Consultas agendadas</h1>
        <div class="pb-5" style="width: 50%; margin: 0 auto;">
            <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Cadastrar paciente" data-toggle="modal" data-target="#modalCadPaciente">

                <i class="fas fa-plus fa-2x fa-spacing2">

                </i>

            </button>
        </div>
        <div class="p-3 pb-5 mt-4" style="width: 50%; margin: 0 auto;background-color: #f2f5ff;">
            <div class=" mt-2 p-3">
                <div id="listInicio">

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCadPaciente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar consulta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-md-4 col-lg-4 col-sm-12">
                            <label for="dataNasciPaciente">Data da consulta</label>
                            <input type="date" maxlength="5" class="form-control datefield" id="dataAgenda">
                            <small id="dateHelper" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-2 col-lg-2 col-sm-12"></div>
                        <div class="form-group col-md-5 col-lg-5 col-sm-12">
                            <label for="nomeConvenio">Tipo de consulta</label>
                            <select class="custom-select selectAgd" name="Eventos2Modal" id="tpConsulta">
                                <option value=""></option>
                                <option value="CONSULTA">CONSULTA</option>
                                <option value="CIRURGIA">CIRURGIA</option>
                                <option value="EXAME">EXAME</option>
                                <option value="RETORNO">RETORNO</option>

                            </select>
                            <small id="tpConsultaHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row" id="listaprocedimentos">
                        <div class="form-group col-md-6 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="dataAgendamento">Procedimentos</label>
                                <select id="cmbStatus" class="selectpicker  form-control" title="Nenhum selecionado" multiple data-selected-text-format="count > 1" data-live-search="true">

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-2 col-lg-2 col-sm-12"></div>
                        <div class="form-group col-md-4 col-lg-4 col-sm-12">
                            <label for="nomeConvenio">Horário da consulta</label>
                            <select class="custom-select selectAgd mt-2" name="Eventos2Modal" id="timer" disabled>
                                <option value=""></option>

                            </select>
                            <small id="tpConsultaHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="agendar()">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
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
<script src="./js/Inicio.js"></script>

<script>
    function logout() {
        localStorage.clear()
        window.location.replace('./Login.php')

    }
</script>