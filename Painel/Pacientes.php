<?php

include("./includes/menu.php");
include("./includes/head.php");
?>


<body class="mt-5" id="bodyPacientes">


    <div class="containerGrid pt-5">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu">Pacientes</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">

                <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Cadastrar paciente" data-toggle="modal" data-target="#modalCadPaciente">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button>
                <table id="listasJqueryPacientes" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 20vw;">Nome</th>
                            <th style="width: 5vw;">CPF</th>
                            <th style="width: 7vw;">RG</th>
                            <th style="width: 3vw;">Data de nascimento</th>
                            <th style="width: 20vw;">Telefone</th>
                            <th style="width: 7vw;">Celular</th>
                            <th style="width: 7vw;">Ações</th>

                        </tr>
                    </thead>
                    <tbody id="gridPacientes"></tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="modalCadPaciente" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content p-4">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="namePaciente">Nome Completo</label>
                        <input type="text" class="form-control caps" id="namePaciente" maxlength="70" placeholder="nome do paciente" autocomplete="off">
                        <small id="namePacienteHelper" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="telPaciente">Telefone</label>
                        <input type="text" class="form-control caps" id="telPaciente" maxlength="70" placeholder="(00)00000-0000" autocomplete="off">

                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="celularPaciente">Celular</label>
                        <input type="text" class="form-control caps" id="celularPaciente" maxlength="70" placeholder="(00)00000-0000" autocomplete="off">

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
                        <input type="text" class="form-control caps" id="EndPaciente" placeholder="Ex: Rua das flores" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="BairroPaciente">Bairro</label>
                        <input type="text" class="form-control caps" id="BairroPaciente" placeholder="Ex: Jardins" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="cidadePaciente">Cidade</label>
                        <input type="text" class="form-control caps" id="cidadePaciente" placeholder="Ex: São paulo" autocomplete="off">

                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="EstadoPaciente">Estado</label>
                        <input type="text" class="form-control caps" id="EstadoPaciente" placeholder="Ex:São paulo" autocomplete="off">
                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="NumeroPaciente">Numero</label>
                        <input type="text" class="form-control caps" id="NumeroPaciente" placeholder="Ex: 123" autocomplete="off">
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
                    <label for="nomeConvenio">Informações complementares</label>
                    <div class="form-group col-md-12 ">
                        <textarea class="form-control caps" placeholder="Informações complementares" id="observacaoAgenda" rows="3" name="obs">

                            </textarea>
                    </div>
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
</body>
<?php include("./includes/imports.php") ?>
<?php include("./includes/messageModal.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./js/toast.js"></script>
<script src="./js/Pacientes.js"></script>