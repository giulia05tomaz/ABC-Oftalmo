<?php include("./includes/menu.php") ?>
<?php include("./includes/head.php") ?>

<body class="mt-5">
    <div class="containerGrid pt-3">
        <div class="d-flex justify-content-center">
            <h3 class="font-weight-bold h3menu">Fechamento</h3>
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
                    <div class="col-12 col-sm-12 col-md-6">
                        <?php
                        if ($_GET['room'] == 1) {
                        ?>
                            <a class=" btn btn-darkblue float-right" target="_blank" id="makePdf" href="./web_services/makePdf/pdf_fechamento.php?params=1">Imprimir</a>
                        <?php
                        } else {
                        ?>
                            <a class=" btn btn-darkblue float-right" target="_blank" id="makePdf" href="./web_services/makePdf/pdf_fechamento.php?params=2">Imprimir</a>
                        <?php
                        }
                        ?>


                    </div>
                </div>
                <!-- <button type="button" class="btn btn-darkblue float-right mr-2 btn-custom-x" title="Novo agendamento" data-toggle="modal" data-target="#modalCadAgendamentos">

                    <i class="fas fa-plus fa-2x fa-spacing2">

                    </i>

                </button> -->
                <table id="listasJqueryFechamentos" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" style="width: 7vw;">Nº Recibo</th>
                            <th class="th-sm" style="width: 15vw;">Cliente</th>
                            <th class="th-sm" style="width: 5vw;">Parcela</th>
                            <th class="th-sm" style="width: 7vw;">Data</th>
                            <th class="th-sm" style="width: 15vw;">Valor Total dos procedimentos</th>
                            <th class="th-sm" style="width: 15vw;">Valor Recebido</th>

                        </tr>
                    </thead>
                    <tbody id="gridFechamentos"></tbody>
                </table>

            </div>
        </div>
    </div>
</body>
<?php include("./includes/imports.php") ?>
<?php include("./includes/messageModal.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./js/toast.js"></script>
<script src="./js/Fechamento.js"></script>