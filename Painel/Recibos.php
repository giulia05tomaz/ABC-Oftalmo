<?php include("./includes/menu.php") ?>
<?php include("./includes/head.php") ?>

<body class="mt-5">
    <div class="containerGrid pt-3">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu">Recibos</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <label for="namePaciente">Filtrar por data específica ou por período</label>
                        <div class="row">
                            <span style="margin: 10px;">De </span>
                            <input type="date" max="1979-12-31" maxlength="5" class="form-control dateAgenda " id="filterAgenda">
                            <span style="margin: 10px;">Até </span>
                            <input type="date" max="1979-12-31" maxlength="5" class="form-control dateAgenda " id="filterAgendaFim">
                        </div>
                    </div>

                </div>
                <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Novo agendamento" data-toggle="modal" data-target="#modalCadAgendamentos">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button>
                <table id="listasJqueryRecibos" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 5vw;">Nº Recibo</th>
                            <th class="th-sm" style="width: 15vw;">Cliente</th>
                            <th class="th-sm" style="width: 5vw;">Parcela</th>
                            <th class="th-sm" style="width: 7vw;">Data</th>
                            <th class="th-sm" style="width: 15vw;">Valor</th>
                            <th class="th-sm" style="width: 15vw;">Descontos</th>
                            <th class="th-sm" style="width: 15vw;">Valor recebido</th>
                            <th class="th-sm" style="width: 15vw;">Data recebido</th>
                            <th class="th-sm" style="width: 15vw;">Tipo</th>
                            <th class="th-sm" style="width: 7vw;">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="gridRecibos"></tbody>

                </table>

            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="modalCadAgendamentos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content p-4">
                <div class="form-row">

                    <div class="form-group col-md-12 col-lg-12  text-center">
                        <button type="button" class="btn btn-darkblue" id="psePaciente" data-toggle="modal" data-target="#modalPesPac">Pesquisar paciente</button>
                        <div class="form-row" style="justify-content: center;">

                            <small id="selectPac" class="text-danger" style="font-size: 20px;"></small>
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-lg-3">
                        <label for="dtRecibo">Data de do recibo</label>
                        <input type="date" maxlength="5" class="form-control datefield inputClean" id="dtRecibo">
                        <small id="dtReciboSpan" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-lg-6">
                        <label for="namePaciente">Nome Completo</label>
                        <input disabled type="text" class="form-control caps inputClean" id="namePaciente" maxlength="70" placeholder="nome do paciente" autocomplete="off">
                        <small id="namePacienteHelper" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-6 col-lg-3">
                        <label for="CpfPaciente">CPF</label>
                        <input disabled type="text" class="form-control inputClean" id="CpfPaciente" maxlength="14" placeholder="00.000.000-0" autocomplete="off">

                    </div>
                    <div class="form-group col-md-6 col-lg-3">
                        <label for="dataNasciPaciente">Data de nascimento</label>
                        <input disabled type="date" maxlength="5" class="form-control datefield inputClean" id="dataNasciPaciente">
                        <small id="dtAdmisTrHelpCad" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6 col-lg-2 col-sm-12">
                        <label for="telPaciente">Telefone</label>
                        <input disabled type="text" class="form-control inputClean" id="telPaciente" maxlength="70" placeholder="(00)0000-0000" autocomplete="off">

                    </div>

                    <div class="form-group col-md-6 col-lg-2 col-sm-12">
                        <label for="celularPaciente">Celular</label>
                        <input disabled type="text" class="form-control inputClean" id="celularPaciente" maxlength="70" placeholder="(00)00000-0000" autocomplete="off">

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
                        <input disabled type="text" class="form-control inputClean" id="nomeConvenio" autocomplete="off">

                    </div>
                </div>

                <div class="form-row" id="listaprocedimentos">
                    <div class="form-group col-md-6 col-lg-4 col-sm-12">
                        <div class="form-group">
                            <label for="dataAgendamento">Procedimentos</label>
                            <select id="cmbStatus" data-count-selected-text=" {0} itens selecionados" class="selectpicker form-control" title="Nenhum selecionado" multiple data-selected-text-format="count > 1" data-live-search="true">

                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-12 col-lg-12  text-center">
                        <button type="button" class="btn btn-darkblue" id="formPagamento">
                            Formas de pagamento</button>
                        <div class="form-row" style="justify-content: center;">

                            <small id="selectPac" class="text-danger" style="font-size: 20px;"></small>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <div class="container-fluid">
                        <div class="row text-right justify-content-end">

                            <div class="d-flex text-right col-md-12 col-12 col-sm-12 justify-content-end">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                <button type="button" class="btn btn-darkblue" id="cadastrarAgendamento" onclick="gravarRecibos()">CADASTRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade bd-example-modal-lg" id="modalPagamentos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content p-4">
                <div class="form-row mt-3">
                    <div class="form-group col-md-6 col-lg-3 col-sm-12">
                        <label for="valPay">Valor pago em dinheiro</label>
                        <input type="text" class="form-control inputClean" onchange="onchangeinput()" id="valPay" maxlength="10" autocomplete="off">

                    </div>
                    <div class="form-group col-md-6 col-lg-3 col-sm-12">
                        <label for="descount">Descontos</label>
                        <input type="text" class="form-control inputClean" onchange="onchangeinput()" id="descount" maxlength="10" autocomplete="off">

                    </div>
                    <div class="form-group col-md-6 col-lg-3 col-sm-12">
                        <label for="totalRecibo">Total dos procedimentos</label>
                        <input disabled type="number" class="form-control inputClean" id="totalRecibo" maxlength="10" autocomplete="off">

                    </div>
                    <div class="form-group col-md-6 col-lg-3 col-sm-12">
                        <label for="valaPay">Valor a pagar</label>
                        <input disabled type="number" class="form-control inputClean" id="valaPay" maxlength="10" autocomplete="off">

                    </div>

                </div>
                <div class="form-row mt-3 ">
                    <div class="form-group col-md-2 col-lg-2 col-sm-12">
                        <label for="valPayCard">Valor pago em cartão</label>
                        <input disabled type="text" class="form-control inputClean" onchange="onchangeinput()" id="valPayCard" maxlength="10" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3 col-lg-3 col-sm-12">
                        <label class="mb-0" for="valPayCard">Tipo de pagameno com cartão</label>


                        <select id="cmbStatusPagamento" data-count-selected-text=" {0} itens selecionados" class="selectpicker form-control" title="Nenhum selecionado" multiple data-selected-text-format="count > 2" data-live-search="true">
                            <option value=""></option>
                            <option id="DEB" value="DEBITO">DEBITO</option>
                            <option id="CRD" value="CREDITO">CRÉDITO</option>
                        </select>

                    </div>
                    <!-- <div class="form-group col-md-3  col-lg-3 col-sm-12">
                        <label for="valPayCard">Novo valor pago</label>
                        <input disabled type="text" class="form-control inputClean" onchange="onchangeinput()" id="valNewpay" maxlength="10" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3  col-lg-3 col-sm-12">
                        <label for="dataNasciPaciente">Data do novo valor</label>
                        <input disabled type="date" maxlength="5" class="form-control datefield inputClean" id="dtNewVal">
                        <small id="dtNewValLabel" class="text-danger"></small>
                    </div> -->
                </div>
                <div class="form-row mt-3">

                    <div class="form-group ml-4 col-md-6 col-lg-5 col-sm-12">
                        <label for="totalRecibo">Tipo de pagamento</label>
                        <div class="form-row" id="formRowType">
                            <div class="form-group col-md-6 col-lg-4 col-sm-12">
                                <input value="DINHEIRO" class="checkboxList" type="checkbox" id="money" />
                                <label for="totalRecibo">Dinheiro</label>

                            </div>
                            <div class="form-group col-md-6 col-lg-4 col-sm-12">
                                <input value="CARTAO" class="checkboxList" type="checkbox" id="card" />
                                <label for="totalRecibo">Cartão</label>

                            </div>
                            <div class="form-group col-md-6 col-lg-4 col-sm-12">
                                <input value="CHEQUE" class="checkboxList" type="checkbox" id="cheque" />
                                <label for="totalRecibo">Cheque</label>

                            </div>

                        </div>
                    </div>
                    <div class="form-group ml-4 col-md-6 col-lg-6 col-sm-12">
                        <label for="totalRecibo">Forma de pagamento</label>
                        <div class="form-row" id="formRowForm">
                            <div class="form-group col-md-4 col-lg-4 col-sm-12">
                                <input value="A VISTA" class="checkboxList" type="checkbox" id="avisible" />
                                <label for="totalRecibo">À vista</label>

                            </div>
                            <div class="form-group col-md-4 col-lg-4 col-sm-12">
                                <input value="PARCELADO" class="checkboxList" type="checkbox" id="parcel" />
                                <label for="totalRecibo">Parcelado</label>

                            </div>
                            <div class="form-group col-md-4 col-lg-4 col-sm-12">
                                <label for="totalRecibo">Total de parcelas</label>
                                <input type="number" max="12" disabled class="form-control inputClean" id="totalParcels" maxlength="10" autocomplete="off">
                                <small id="totalParcelshelp" class="text-danger"></small>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="form-row mt-3 justify-content-center">
                    <div class="form-group col-md-12 col-lg-12 col-sm-12">
                        <table id="listasJqueryPacientes" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" style="width: 10vw;">Número da parcela</th>
                                    <th class="th-sm" style="width: 6vw;">Valor</th>
                                    <th class="th-sm" style="width: 5vw;">Data da parcela</th>


                                </tr>
                            </thead>
                            <tbody id="gridParcels"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">

                    <div class="container-fluid">
                        <div class="row text-right justify-content-end">

                            <div class="d-flex text-right col-md-12 col-12 col-sm-12 justify-content-end">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                <button type="button" class="btn btn-darkblue" data-dismiss="modal">CONFIRMAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <?php include("./includes/modalSearchPaciente.php") ?>
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

                    <a type="button" class="btn  waves-effect btn-outline-danger" onclick="deletaPaciente()" data-dismiss="modal">Ok</a>
                    <a type="button" class="btn  waves-effect btn-darkblue" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <div class="modal fade" id="deletaRecibos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

                    <a type="button" class="btn  waves-effect btn-outline-danger" onclick="deletaRecibos()" data-dismiss="modal">Ok</a>
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
<script src="./js/Recibos.js"></script>