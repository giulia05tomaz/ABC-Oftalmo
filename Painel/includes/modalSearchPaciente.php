<div class="modal fade bd-example-modal-lg" id="modalPesPac" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content p-1">

            <div class="d-flex justify-content-center">
                <h3 class="font-weight-bold">Pacientes </h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <input type="text" class="form-control caps ml-2" id="pesqPaciente" maxlength="70" placeholder="Pesquise por nome ou CPF" autocomplete="off">
                </div>
                <div class="col-md-2" id="totalReg" style="left:5px; padding-top: 7px;">
                    <span style="">Total de registros: <span id="spanTotal"></span></span>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Pesquisar paciente" onclick="filterPacientes()">
                        <i class="fas fa-search fa-2x fa-spacing2"></i>
                    </button>
                </div>
                <div class="container pt-1 listPacientes">
                    <table id="listasJqueryPacientes" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm" style="width: 10vw;">Nome</th>
                                <th class="th-sm" style="width: 6vw;">CPF</th>
                                <th class="th-sm" style="width: 5vw;">Data de nascimento</th>
                                <th class="th-sm" style="width: 5vw;">Telefone</th>
                                <th class="th-sm" style="width: 5vw;">Celular</th>
                                <th class="th-sm" style="width: 3vw;">Convênio</th>
                                <th class="th-sm" style="width: 10vw;">Nome do convênio</th>

                            </tr>
                        </thead>
                        <tbody id="gridPacientes"></tbody>
                    </table>
                    <div class="text-center visibleGridText" style="display: none;">
                        <span class="text-center ">Registros não encontrados</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>