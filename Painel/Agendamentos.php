<?php include("./includes/menu.php") ?>
<?php include("./includes/head.php") ?>


<body class="mt-5">
    <div class="containerGrid pt-3" style="width: 97% !important;">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu text-center">Agendamentos</h3>
        </div>
        <div class="row ">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-12">
                        <label class="ml-2" for="namePaciente">Filtrar por data específica </label>
                        <div class="row">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8">

                                <!-- <input type="date" maxlength="5" onclick="getfUNCTION('click')" onsubmit="getfUNCTION('submit')" class="form-control dateAgenda " id="filterAgenda"> -->
                                <input disabled class="flatpickr flatpickr-input active" id="flatpickrConsult" type="text" placeholder="Selecione a data" data-id="datetime" readonly="readonly">
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 mt-4">
                                <div class="form-group col-md-12 col-lg-12  text-left">
                                    <button type="button" class="btn btn-darkblue " id="psePaciente" data-toggle="modal" data-target="#modalPesPac">Pesquisar por paciente</button>
                                    <div class="row justify-content-center">
                                        <!-- <small id="psePacienteHelper" class="text-danger"></small> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <?php
                        if ($_GET['room'] == 1) {
                        ?>
                            <a class=" btn btn-darkblue float-right" target="_blank" id="makePdf" href="./web_services/makePdf/pdf_agendamentos.php?params=1">Imprimir</a>
                        <?php
                        } else {
                        ?>
                            <a class=" btn btn-darkblue float-right" target="_blank" id="makePdf" href="./web_services/makePdf/pdf_agendamentos.php?params=2">Imprimir</a>
                        <?php
                        }
                        ?>

                        <!-- <button type="button" class="btn btn-darkblue float-right" data-dismiss="modal">Imprimir</button> -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Novo agendamento" data-toggle="modal" data-target="#modalCadAgendamentos">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button>
                <table id="listasJquery" class=" stripe hover  table table-striped table-bordered table-sm lsJQuery" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="max-width: 7vw !important;">Data</th>
                            <th class="th-sm" style="max-width: 7vw !important;">Horário</th>
                            <th class="th-sm" style="max-width: 7vw !important;">tipo</th>
                            <th class="th-sm" style="max-width: 7vw !important;">Paciente</th>
                            <th style="max-width: 7vw !important;">Observações</th>
                            <th class="th-sm" style="max-width: 10vw!important;">Status</th>
                            <th class="th-sm" style="max-width: 7vw !important;">Ações</th>

                        </tr>
                    </thead>
                    <tbody id="gridHome"></tbody>
                </table>


            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="modalCadAgendamentos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-xl">
                <div class="modal-content p-4">
                    <div class="form-row">

                        <div class="form-group col-md-12 col-lg-12  text-center">
                            <button type="button" class="btn btn-darkblue" id="psePaciente2" data-toggle="modal" data-target="#modalPesPac">Pesquisar paciente</button>
                            <div class="row justify-content-center">
                                <small id="psePacienteHelper" class="text-danger"></small>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-lg-6">
                            <label for="namePaciente">Nome Completo</label>
                            <input disabled type="text" class="form-control caps" id="namePaciente" maxlength="70" placeholder="nome do paciente" autocomplete="off">
                            <small id="namePacienteHelper" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6 col-lg-3">
                            <label for="CpfPaciente">CPF</label>
                            <input disabled type="text" class="form-control " id="CpfPaciente" maxlength="14" placeholder="00.000.000-0" autocomplete="off">

                        </div>
                        <div class="form-group col-md-6 col-lg-3">
                            <label for="dataNasciPaciente">Data de nascimento</label>
                            <input disabled type="date" maxlength="5" class="form-control datefield" id="dataNasciPaciente">
                            <input class="flatpickr flatpickr-input active datefield" type="text" id="dataNasciPaciente" placeholder="Selecione a data" data-id="datetime" readonly="readonly">
                            <small id="dtAdmisTrHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-6 col-lg-2 col-sm-12">
                            <label for="telPaciente">Telefone</label>
                            <input disabled type="text" class="form-control " id="telPaciente" maxlength="20" placeholder="(00)0000-0000" autocomplete="off">

                        </div>

                        <div class="form-group col-md-6 col-lg-2 col-sm-12">
                            <label for="celularPaciente">Celular</label>
                            <input disabled type="text" class="form-control " id="celularPaciente" maxlength="70" placeholder="(00)00000-0000" autocomplete="off">

                        </div>
                        <div class="form-group col-md-6 col-lg-3 col-sm-12">
                            <label for="NumeroPaciente">Convênio</label>
                            <select disabled class="custom-select selectAgd" name="Eventos2Modal" id="isConvenioModal">
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NAO">NÃO</option>

                            </select>

                        </div>
                        <div class="form-group col-md-6 col-lg-5 col-sm-12">
                            <label for="nomeConvenio">Nome do convênio</label>
                            <input disabled type="text" class="form-control" id="nomeConvenio" autocomplete="off">

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6 col-lg-4 col-sm-12">
                            <label for="nomeConvenio">Tipo de consulta</label>
                            <select onchange="cleanSmall('tpConsultaHelpCad')" class="custom-select selectAgd" name="Eventos2Modal" id="tpConsulta">
                                <option value=""></option>
                                <option value="CONSULTA">CONSULTA</option>
                                <option value="CIRURGIA">CIRURGIA</option>
                                <option value="EXAME">EXAME</option>
                                <option value="RETORNO">RETORNO</option>

                            </select>
                            <small id="tpConsultaHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-1 col-sm-12"></div>
                        <div class="form-group col-md-6 col-lg-2 col-sm-12">
                            <label for="nomeConvenio">Confirmado</label>
                            <select onchange="cleanSmall('confirmadoHelpCad')" class="custom-select selectAgd" name="Eventos2Modal" id="confirmadoConsultaModal">
                                <option value=""></option>
                                <option value="SIM">SIM</option>
                                <option value="NAO">NÃO</option>

                            </select>
                            <small id="confirmadoHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-1 col-sm-12"></div>
                        <div class="form-group col-md-6 col-lg-2 col-sm-12">
                            <label for="dataAgendamento">Data do agendamento</label>
                            <input class="flatpickr flatpickr-input active" id="dataAgendamento" type="text" placeholder="Selecione a data" data-id="datetime" readonly="readonly">
                            <!-- <input onchange="cleanSmall('dataAgeaHelpCad')" type="date" id="dataAgendamento" autocomplete="off"> -->
                            <small id="dataAgeaHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6 col-lg-2 text-center col-sm-12">
                            <label for="hrAgendamento">Hora do agendamento</label>
                            <input onchange="cleanSmall('hrAgendHelpCad')" type="time" id="hrAgendamento" autocomplete="off">
                            <small id="hrAgendHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-row" id="listaprocedimentos">
                        <div class="form-group col-md-6 col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label for="dataAgendamento">Procedimentos</label>
                                <select id="cmbStatus" data-count-selected-text=" {0} itens selecionados" class="selectpicker  form-control" title="Nenhum selecionado" multiple data-selected-text-format="count > 1" data-live-search="true">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="nomeConvenio">Observação</label>
                        <textarea class="form-control textControl" placeholder="Digite a observação" id="observacaoAgenda" name="obs">

                            </textarea>
                    </div>

                    <?php
                    if ($_SESSION['nvAcesso'] < 3) {
                    ?>
                        <h5 for="nomeConvenio" class="text-center">Prontuário</h5>
                        <div class="float-right obsAtalho">
                            <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" onclick="add_obs_cad(`divtextArea-0`)"><i class="fas fa-plus fa-2x fa-spacing2"></i></button>
                        </div>
                        <div class="form-group obs" id="obs">


                            <div class="form-group listObs" id="obsAfast">
                                <div class="form-row campoObs" id="divtextArea-0">
                                    <textarea id="textArea-0" class="form-control txtObs caps" rows="3" placeholder="Digite uma observação" style="width: 90%;"></textarea>
                                    <!-- <button type="button" class="btn color-red btn-custom-vk" onclick="del_obs_cad(event, `divtextArea-0`)"><i class="fas fa-trash fa-lg fa-spacingDelete"></i></button> -->
                                    <span class="errorTextArea">Adcione um texto</span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="modal-footer">

                        <div class="container-fluid">
                            <div class="row text-right justify-content-end">

                                <div class="d-flex text-right col-md-12 col-12 col-sm-12 justify-content-end">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>

                                    <button type="button" class="btn btn-darkblue" id="cadastrarAgendamento" onclick="cadastraAgendamento('0')">CADASTRAR</button>
                                    <?php
                                    if ($_SESSION['nvAcesso'] < 3) {

                                    ?>
                                        <button type="button" class="btn btn-darkblue" id="finAgenda" style="display: none;" onclick="cadastraAgendamento('1')">FINALIZAR AGENDAMENTO</button>
                                    <?php
                                    }
                                    ?>
                                </div>
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

                    <a type="button" class="btn  waves-effect btn-outline-danger" onclick="deletaAgenda()" data-dismiss="modal">Ok</a>
                    <a type="button" class="btn  waves-effect btn-darkblue" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <?php include("./includes/modalSearchPaciente.php") ?>


</body>

<?php include("./includes/imports.php") ?>
<?php include("./includes/messageModal.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./node_modules/flatpickr/dist/l10n/pt.js"></script>
<script src="./js/toast.js"></script>
<script src="./js/Agendamentos.js"></script>