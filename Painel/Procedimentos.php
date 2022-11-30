<?php
include("./includes/menu.php");
include("./includes/head.php");
?>

<body class="mt-5">
    <div class="containerGrid pt-5">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu">Procedimentos</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">

                <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Novo agendamento" data-toggle="modal" data-target="#modalCadProced">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button>
                <table id="listasJqueryProced" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 15vw;">Descrição</th>
                            <th class="th-sm" style="width: 15vw;">Valor Particular</th>
                            <th class="th-sm" style="width: 15vw;">Valor Convênio</th>
                            <th class="th-sm" style="width: 15vw;">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="gridProcedimentos"></tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalCadProced" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content p-4">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="descProced">Descrição</label>
                        <input type="text" class="form-control caps" id="descProced" onkeyup="limpaSpan('descproced')" maxlength="70" placeholder="Descrição" autocomplete="off">
                        <small id="descproced" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="valPart">Valor particular</label>
                        <input type="text" class="form-control " id="valPart" onkeyup="limpaSpan('spanValPart')" maxlength="9" autocomplete="off">
                        <small id="spanValPart" class="text-danger"></small>
                    </div>
                    <div class="form-group col-md-1"></div>
                    <div class="form-group col-md-2">
                        <label for="valConv">Valor convênio</label>
                        <input type="text" class="form-control " id="valConv" onkeyup="limpaSpan('spanvalConv')" maxlength="9" autocomplete="off">
                        <small id="spanvalConv" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="d-flex text-left col-md-6   justify-content-start" id="footerTrab"></div>
                            <div class="d-flex text-right col-md-6 col-12 col-sm-12 justify-content-end">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
                                <button type="button" class="btn btn-darkblue" onclick="gravadProced()" id="ConfCadTrab">CADASTRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

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

                <a type="button" class="btn  waves-effect btn-outline-danger" onclick="deletaProcedimentos()" data-dismiss="modal">Ok</a>
                <a type="button" class="btn  waves-effect btn-darkblue" data-dismiss="modal">Cancelar</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<?php include("./includes/imports.php") ?>
<?php include("./includes/messageModal.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./js/toast.js"></script>
<script src="./js/Procedimentos.js"></script>