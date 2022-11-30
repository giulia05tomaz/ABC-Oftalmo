$(document).ready(function () {
    if (window.location.search.includes('idAgenda')) {
        $("#psePaciente").attr('disabled', true)
        const params = window.location.search.split('&')[1]
        getInfoPaciente(params.replace('idAgenda=', ''))
    }

});
function executaTabelaRecibos() {
    $('#listasJqueryRecibos').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJqueryRecibos').DataTable({
        scrollY: '60vh',
        scrollCollapse: true,
        heigth: '200px',
        lengthMenu: [20, 50, 70],
        language: {
            info: 'Exibindo página _PAGE_ de _PAGES_',
            emptyTable: 'Não foram encontrados registros',
            infoEmpty: 'Não foram encontrados registros',
            sZeroRecords: 'Não foram encontrados registros',
            infoFiltered: ' - filtrado _TOTAL_ de _MAX_ entradas',
            sLengthMenu: 'Exibindo _MENU_ Registros',
            search: 'Buscar',
            paginate: {
                next: 'Próximo',
                previous: 'Anterior',
            },
        },
    });
}


var identificadorModal = 0
var identificadorPac = 0
var dateAtual = formatDate(new Date(), 'en')



$("#dtRecibo").val(dateAtual)
$("#filterAgenda").val(dateAtual)
$("#filterAgendaFim").val(dateAtual)



function listaDadosTable() {

    $("#dtRecibo").val(dateAtual)

    $("#observacaoAgenda").val('')
    $('#listasJqueryRecibos').DataTable().destroy();
    $("#gridRecibos").html('')

    var JsonEnvio = {
        roomLocation: window.location.search.replace('?room=', ''),
        days1: $("#filterAgenda").val(),
        days2: $("#filterAgendaFim").val(),
    }


    $.ajax({
        type: "POST",
        url: "./web_services/ws-recibos.php/listRecibos",
        data: JSON.stringify(JsonEnvio),
        success: function (response) {

            var jsonListar = JSON.parse(response)
            if (jsonListar.length < 1) {
                executaTabelaRecibos()
                $('#preloader .inner').delay(1000).fadeOut();
                $('#preloader').delay(1000).fadeOut('slow');
                $('body').delay(1000).css({ 'overflow': 'visible' });
                return;
            }
            jsonListar.map((item, index) => {

                $('#gridRecibos').append(`
                <tr class="text-center" >
                  <td>${item.identificador}</td>
                  <td>${item.namePac}</td>
                  <td>${item.parc}</td>
                  <td>${item.dataAtualInclude}</td>
                  <td>${Number(item.total).toFixed(2)}</td>
                  <td>${Number(item.discontos).toFixed(2)}</td>
                  <td>${Number(item.totalRcb).toFixed(2)}</td>
                  <td>${item.dataInclusao}</td>
                  <td>${item.typeRcb.replace(/[\[\]\"]+/g, "")}</td>
                
                  <td class="text-center">
                    <button type="button" class="btn btn-darkblue btn-custom-w alteraRcb"  id = "${item.identificador}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                    <button type="button" class="btn btn-danger btn-custom-w deletaRecibos"  id="${item.identificador}"><i class="fas fa-trash fa-lg fa-spacing"></i></button>
                    <a  type="button" class=" btn btn-primary btn-custom-w imprimir" target="_blank" id="makePdf"href="./web_services/makePdf/pdf_recibos.php?item=${encodeURIComponent(JSON.stringify(item))}">
                    <i class="fas fa-print fa-lg fa-spacing"></i></a>
                   
                    </td>
                </tr>
               
                `)
            })
            executaTabelaRecibos()
            $('#preloader .inner').delay(1000).fadeOut();
            $('#preloader').delay(1000).fadeOut('slow');
            $('body').delay(1000).css({ 'overflow': 'visible' });
        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro na requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })



}
var dateAtual = formatDate(new Date(), 'en')
$('#filterAgenda').focusout(function () {

    if ($('#filterAgenda').val().length > 9 && $('#filterAgenda').val() != dateAtual) {
        if ($('#filterAgenda').val() > $('#filterAgendaFim').val()) {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('A primeira data não pode ser maior que a segunda data! ')
            $("#modalMessage").modal('show')
            $("#filterAgenda").val(formatDate(new Date(), 'en'))
            return
        }
        listaDadosTable()


    }
})
$('#filterAgendaFim').focusout(function () {
    if ($('#filterAgendaFim').val().length > 9 && $('#filterAgendaFim').val() != dateAtual) {
        if ($('#filterAgenda').val() > $('#filterAgendaFim').val()) {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('A primeira data não pode ser maior que a segunda data! ')
            $("#modalMessage").modal('show')
            $("#filterAgenda").val(formatDate(new Date(), 'en'))
            return;
        }
        listaDadosTable()


    }
})


$(document).on('click', '.deletaRecibos', function () {
    identificadorModal = $(this).attr('id')
    $("#deletaRecibos").modal('show')
})

function deletaRecibos() {


    $.ajax({
        type: "POST",
        url: "./web_services/ws-recibos.php/deletaRecibos",
        data: { identificador: identificadorModal },
        success: function (response) {
            $('#preloader .inner').fadeIn();
            $('#preloader').fadeIn('slow');
            $('body').css({ 'overflow': 'hiden' });
            listaDadosTable()

        }
    })
}
const fasda = function (parcels) {
    $("#card").prop('checked', true)
    $("#TypeCard").prop('disabled', false)
    $('#cmbStatusPagamento').attr('disabled', false)
    $('#cmbStatusPagamento').selectpicker('refresh');
    $("#valPayCard").prop('disabled', false)


    $("#gridParcels").html('');
    var i = 0;
    var dateInlude = $("#dtRecibo").val()
    var totalCard = Number($("#valPayCard").val())


    if (!$("#parcel").prop('checked')) return
    var data = new Date(dateInlude);

    var numFloat = Number(parseFloat(totalCard / Number(parcels)).toFixed(2))
    while (i < Number(parcels)) {
        const dataSum = i == 1 ? data.setDate(data.getDate() + 1) : data.setDate(data.getDate() + 30);
        $("#gridParcels").append(`
            <tr class="text-center" >
            <td>${i + 1}</td>
            <td>${numFloat.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })}</td>
            <td>${formatDate(new Date(dataSum), 'pt')}</td>
            `)
        i++
    }

}
$(document).on('click', '.alteraRcb', function () {
    identificadorModal = $(this).attr('id')
    identificadorPac = $(this).attr('id')
    $("#psePaciente").attr('disabled', true)
    $.ajax({
        type: "POST",
        url: "./web_services/ws-recibos.php/infosRecibos",
        data: { identificador: identificadorModal },
        success: function (response) {
            var jsonResponse = JSON.parse(response)
            var jsonTypePyment = JSON.parse(jsonResponse.tipo)


            jsonResponse.fmPagamento == "A VISTA" ? $("#avisible").prop('checked', true) : jsonResponse.fmPagamento == "PARCELADO" ? $("#parcel").prop('checked', true) : null

            var formPayment = jsonResponse.fmPagamento
            $('#valPay').val(Number(jsonResponse.totalRecebido).toFixed(2))
            $('#descount').val(Number(jsonResponse.discount).toFixed(2))
            $('#totalRecibo').val(Number(jsonResponse.total).toFixed(2))
            $('#valaPay').val(Number(jsonResponse.valaPay).toFixed(2))
            $("#cadastrarAgendamento").text('ALTERAR')
            $("#namePaciente").val(jsonResponse.namePac)
            $("#CpfPaciente").val(jsonResponse.codeCpfPac)
            $("#dataNasciPaciente").val(jsonResponse.dt_nascPac)
            $("#totalParcels").val(jsonResponse.parcelas)
            $("#valPayCard").val(jsonResponse.totalRecbCard)
            $("#telPaciente").val(jsonResponse.telPac)
            $("#TypeCard").val(jsonResponse.typeCard)
            $("#celularPaciente").val(jsonResponse.celPac)
            $("#isConvenioModal").val(jsonResponse.convPac)
            $("#nomeConvenio").val(jsonResponse.nameConvPac)
            $("#dtRecibo").val(jsonResponse.dtVencimento)
            var resposeArray = JSON.parse(jsonResponse.idProcedimentos)
            var resposeArrayTypecard = JSON.parse(jsonResponse.typeCard)
            jsonTypePyment.includes("DINHEIRO") ? $("#money").prop('checked', true) : null
            jsonTypePyment.includes("CARTAO") ? fasda(jsonResponse.parcelas) : null
            jsonTypePyment.includes("CHEQUE") ? $("#cheque").prop('checked', true) : null

            resposeArray.map(function (item, index) {
                $(`#cmbStatus option[id='${item}']`).prop('selected', true)
                $(`#cmbStatus option[id='${item}']`).prop('selected', true)
            })

            if (resposeArrayTypecard?.length > 1) {
                $(`#cmbStatusPagamento option[id='DEB']`).prop('selected', true)
                $(`#cmbStatusPagamento option[id='CRD']`).prop('selected', true)

            } else if (resposeArrayTypecard.length == 1) {
                resposeArrayTypecard[0] == "DEBITO" ? $(`#cmbStatusPagamento option[id='DEB']`).prop('selected', true)
                    : $(`#cmbStatusPagamento option[id='CRD']`).prop('selected', true)

            }

            $('#cmbStatusPagamento').selectpicker('refresh');
            $('#cmbStatus').selectpicker('refresh');
            $("#modalCadAgendamentos").modal('show')

        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro na requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
})


listaDadosTable()

function filterPacientes() {

    var inputFilter = $("#pesqPaciente").val().toUpperCase()

    $('#gridPacientes').html('')
    $.ajax({
        type: "POST",
        url: "./web_services/ws-pacientes.php/pesquisarPacientes",
        data: { inputFilter },
        success: function (response) {

            var jsonListar = JSON.parse(response)

            if (jsonListar.length < 1) {
                $('.visibleGridText').addClass("notFound")
                $("#spanTotal").text("0")
                return;
            }
            $('.visibleGridText').removeClass("notFound")
            var totalReg = jsonListar.slice(jsonListar.length - 1, jsonListar.length)

            $("#spanTotal").text(totalReg[0].countids + 1)
            jsonListar.map((item, index) => {

                $('#gridPacientes').append(`
                <tr class="text-center trLinePaciente" name = "${item.identificadorPac}" id="${item.identificadorPac + item.nomePaciente.replace(/[^A-Za-z0-9]+/g, "")}" onclick="ClickTr(this.id,this.attributes['name'].value)">
                  <td id="nomePaciente">${item.nomePaciente}</td>
                  <td id="CpfPaciente">${item.CpfPaciente}</td>
                  <td id="dtNascimento">${item.dtNascimento}</td>
                  <td id="telPaciente">${item.telPaciente}</td>
                  <td id="celPaciente">${item.celpaciente}</td>
                  <td id="isConvenioLista">${item.isConvenio}</td>
                  <td id="nomeConvenio">${item.nomeConvenio}</td>
                
                </tr>
                `)

            })
            $('#cmbStatusPagamento').attr('disabled', true)
            $('#cmbStatusPagamento').selectpicker('refresh');
        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no cadastro, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })



}

$('#dtRecibo').focusout(function () {
    if ($('#dtRecibo').val().length > 9) {
        filterProcedimentos()
        $('#cmbStatus').selectpicker('deselectAll');

    }
})


function ClickTr(resolve, name) {
    $(`#selectPac`).text("")
    $('#cmbStatus').selectpicker('deselectAll');

    var nomePaciente = $(`#${resolve} td#nomePaciente`).text()
    var CpfPaciente = $(`#${resolve} td#CpfPaciente`).text()
    var dtNascimento = $(`#${resolve} td#dtNascimento`).text()
    var telPaciente = $(`#${resolve} td#telPaciente`).text()
    var celPaciente = $(`#${resolve} td#celPaciente`).text()
    var isConvenio = $(`#${resolve} td#isConvenioLista`).text()
    var nomeConvenio = $(`#${resolve} td#nomeConvenio`).text()
    var dtFormated = dtNascimento.split('/')
    identificadorPac = name


    $("#modalPesPac").modal('hide')

    $("#namePaciente").val(nomePaciente)
    $("#CpfPaciente").val(CpfPaciente)
    $("#dataNasciPaciente").val(`${dtFormated[2]}-${dtFormated[1]}-${dtFormated[0]}`)
    $("#telPaciente").val(telPaciente)
    $("#celularPaciente").val(celPaciente)
    $("#isConvenioModal").val(isConvenio)
    $("#nomeConvenio").val(nomeConvenio)

    // $("#descount").val('0')
    // $("#valPay").val('0')
    filterProcedimentos()


}

function getInfoPaciente(identificador) {
    identificadorCad = identificador
    $.ajax({
        type: "POST",
        url: "./web_services/ws-pacientes.php/listaInfopaciente",
        data: { identificador },
        success: function (response) {

            identificadorPac = identificador




            var jsonResponse = JSON.parse(response)
            $("#namePaciente").val(jsonResponse.namePaciente);
            $("#CpfPaciente").val(jsonResponse.cpfPaciente);
            $("#dataNasciPaciente").val(jsonResponse.dataNascimentoPaciente);
            $("#telPaciente").val(jsonResponse.telefonePaciente);
            $("#celularPaciente").val(jsonResponse.celularPaciente);
            $("#isConvenioModal").val(jsonResponse.convenioPaciente);
            $("#nomeConvenio").val(jsonResponse.nameConvPaciente);
            $("#modalCadAgendamentos").modal('show')

            filterProcedimentos()

        }
    })

}

function filterProcedimentos() {
    var DtRecido = $("#dtRecibo").val()
    var isConvenio = $("#isConvenioModal").val()
    $.ajax({
        type: "POST",
        url: "./web_services/ws-recibos.php/filterAgendamentoPac",
        data: { identificadorPac, DtRecido },
        success: function (response) {
            $("#gridprocedimentos").html('')
            var jsonParse = JSON.parse(response)
            var sum = 0
            var selecteds = []
            if (jsonParse.length == 0) {

                $("#totalRecibo").val(0)
                $("#valaPay").val(0)
                return;
            }
            jsonParse.map(function (item, index) {

                selecteds.push(item.identificador)
                sum += isConvenio == "SIM" ? Number(item.valConvenio) : Number(item.valParticular)

            })

            selecteds.map(function (item, index) {
                $(`#cmbStatus option[id='${item}']`).prop('selected', true)

            })
            $('#cmbStatus').selectpicker('refresh');

            $("#totalRecibo").val(Number(sum).toFixed(2))
            $("#valaPay").val(Number(sum).toFixed(2))

        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro na requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
}


$("#money").on('click', function () {
    // $("#card").prop('checked', false)
    $("#cheque").prop('checked', false)

})
$("#card").on('click', function () {
    if ($(this).is(':checked')) {
        $("#valPayCard").prop('disabled', false)
        $('#cmbStatusPagamento').attr('disabled', false)
        $('#cmbStatusPagamento').selectpicker('refresh');

    } else {
        $('#cmbStatusPagamento').selectpicker('deselectAll');
        $("#valPayCard").prop('disabled', true)
        $('#cmbStatusPagamento').attr('disabled', true)
        $('#cmbStatusPagamento').selectpicker('refresh');
        $("#valPayCard").val('0')
        $("#valPayCard").val('')
    }
    // $("#money").prop('checked', false)

    $("#cheque").prop('checked', false)
})
$("#cheque").on('click', function () {
    $("#card").prop('checked', false)
    $("#money").prop('checked', false)
})


$("#avisible").on('click', function () {
    $("#parcel").prop('checked', false)
    $('#totalParcels').val("")
    $("#totalParcels").attr('disabled', true)
    listParcels(0)
})
$("#parcel").on('click', function () {
    $("#avisible").prop('checked', false)

})


function listaprocedimentos() {
    var appendHtml = ''
    $.ajax({
        type: "GET",
        url: `./web_services/ws-agendamentos.php/listaprocedimentos`,
        success: function (response) {
            var jsonResponse = JSON.parse(response)
            var options = []

            jsonResponse.map((item, index) => {

                options.push('<option id = "' + item.identificador + '"  data-srv="' + item.valParticular + '" type="checkbox" value="' + item.valConvenio + '">' + item.descr + '</option>');
            })




            $('#cmbStatus')
                .append(options.join(''))
                .selectpicker('refresh');



        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
}

listaprocedimentos()

function clicaDiv() {
    var visibleCalss = $("#list1").attr('class').includes('visible')
    if (visibleCalss) {
        $(".dropdown-check-list").removeClass('visible')
    } else {

        $(".dropdown-check-list").addClass('visible')
    }
}


$("#cmbStatus").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    if (identificadorPac == 0) {
        $(`#selectPac`).text("Selecione um paciente")
        $('#cmbStatus').selectpicker('deselectAll');


        $('#cmbStatus').selectpicker('refresh');
        return
    }
    $(`#selectPac`).text("")

    if ($(`#cmbStatus`).val().length == 0) {
        $("#descount").val('0')
        $("#valPay").val('0')
        $("#totalRecibo").val('0')
        $("#valaPay").val('0')
        return;
    }

    var valueConvenio = e.currentTarget[clickedIndex].value
    var valueNotConvenio = e.currentTarget[clickedIndex].dataset.srv

    var total = $("#totalRecibo").val() == 0 || $("#totalRecibo").val() == "" ? 0 : $("#totalRecibo").val()

    if (isSelected) {
        if ($("#isConvenioModal").val() == "SIM") {
            $("#totalRecibo").val(parseFloat(Number(total) + Number(valueConvenio)).toFixed(2))
        } else {
            $("#totalRecibo").val(parseFloat(Number(total) + Number(valueNotConvenio)).toFixed(2))
        }
    } else {
        if ($("#isConvenioModal").val() == "SIM") {
            $("#totalRecibo").val(parseFloat(Number(total) - Number(valueConvenio)).toFixed(2))
        } else {
            $("#totalRecibo").val(parseFloat(Number(total) - Number(valueNotConvenio)).toFixed(2))
        }
    }
    onchangeinput()
})


$('#valPay').mask('####0.00', { reverse: true });
$('#valPayCard').mask('####0.00', { reverse: true });
$('#descount').mask('####0.00', { reverse: true });
$('#valaPay').mask('####0.00', { reverse: true });
$('#totalRecibo').mask('####0.00', { reverse: true });

function onchangeinput() {
    const cardValue = $("#valPayCard").val() == "" ? 0 : $("#valPayCard").val()
    const sum = Number($('#valPay').val()) + Number(cardValue)
    $('#valaPay').val(parseFloat(Number($('#totalRecibo').val()) - (sum + Number($('#descount').val())))
        .toFixed(2))
}

function gravarRecibos() {
    var typePayment = $("#money").is(':checked') ? $('#money').val() : $("#card").is(':checked') ? $('#card').val() : $("#cheque").is(':checked') ? $('#cheque').val() : 0
    var formPayment = $("#avisible").is(':checked') ? $('#avisible').val() : $("#parcel").is(':checked') ? $('#parcel').val() : 0

    var jsonTypePayment = [$("#money").is(':checked') ? $('#money').val() : '', $("#card").is(':checked') ? $('#card').val() : '', $("#cheque").is(':checked') ? $('#cheque').val() : '']

    if ($("#card").is(':checked') && $('#cmbStatusPagamento').val().length == 0) {
        $("#tpModal").addClass('modal-warning')
        $("#btTpModal").addClass('btn-outline-warning')
        $("#messageModal").text('Selecione um tipo de pagamento com o cartão')
        $("#modalMessage").modal('show')
        return
    }

    const filterType = jsonTypePayment.filter(item => item !== '')

    if (identificadorPac == 0) {
        $("#tpModal").addClass('modal-warning')
        $("#btTpModal").addClass('btn-outline-warning')
        $("#messageModal").text('Selecione um paciente')
        $("#modalMessage").modal('show')
        return;
    }

    if (typePayment == 0 || formPayment == 0) {
        $("#tpModal").addClass('modal-warning')
        $("#btTpModal").addClass('btn-outline-warning')
        $("#messageModal").text('Selecione a forma e o tipo de pagamento ')
        $("#modalMessage").modal('show')
        return;
    }


    var jsonEnvio = {
        idprocedimentos: identificadorModal,
        identificadorPac: identificadorPac,
        procedimentos: null,
        valPago: $('#valPay').val(),
        valPagoCard: $("#valPayCard").val() == "" ? 0 : $("#valPayCard").val(),
        valDiscount: $('#descount').val(),
        valTotal: $('#totalRecibo').val(),
        valAPay: $('#valaPay').val(),
        typePayment: filterType,
        formPayment: formPayment,
        typeCard: $('#cmbStatusPagamento').val(),
        // typeCard: $('#TypeCard').val(),
        parcels: $('#totalParcels').val() == "" ? 1 : $('#totalParcels').val(),
        dataRecibo: $('#dtRecibo').val(),
        dataVenc: formatDate(new Date(), 'en'),
        rowinsert: window.location.search.replace('?room=', ''),
    }
    var btn = $("#cadastrarAgendamento").text()
    var pushProcedimentos = []

    if ($('#cmbStatus').selectpicker('val').length > 0) {
        $(".selectpicker option ").each(function () {
            if ($(this).is(':checked')) {
                pushProcedimentos.push(Number(this.id))
            }
        })

        jsonEnvio['procedimentos'] = pushProcedimentos
    } else {
        jsonEnvio['procedimentos'] = []
    }

    $.ajax({
        type: "POST",
        url: `./web_services/ws-recibos.php/${btn == "ALTERAR" ? 'updateRecibos' : 'gravaRecibos'}`,
        data: JSON.stringify(jsonEnvio),
        success: function (response) {

            if (response == 'regExist') {
                $("#tpModal").addClass('modal-warning')
                $("#btTpModal").addClass('btn-outline-warning')
                $("#messageModal").text('Registro já existe na data informada, por favor altere o registro existente! ')
                $("#modalMessage").modal('show')
                return;
            }
            $("#tpModal").addClass('modal-success')
            $("#btTpModal").addClass('btn-outline-success')
            $("#messageModal").text('Registro gravado com sucesso! ')
            $("#modalCadAgendamentos").modal('hide')
            $("#modalMessage").modal('show')
            listaDadosTable()


        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
}



$('#modalCadAgendamentos').on('hidden.bs.modal', function (e) {
    $("#psePaciente").attr('disabled', false)
    $('.selectpicker').selectpicker('deselectAll');
    $(`#selectPac`).text("")
    $("#modalCadAgendamentos input.inputClean").val('')
    $("#modalPagamentos input.inputClean").val('')
    $(".selectAgd").val('')
    $("#cadastrarAgendamento").text('CADASTRAR')
    $("#modalCadAgendamentos").modal('hide')
    $('.checkboxList').prop('checked', false);
    $(".dropdown-check-list").removeClass('visible')
    $('#totalParcels').val("")
    $("#totalParcels").attr('disabled', true)
    $("#valPayCard").prop('disabled', true)
    $('#cmbStatusPagamento').attr('disabled', true)
    $('#cmbStatusPagamento').selectpicker('refresh');
    $("#gridParcels").html('');
    identificadorPac = 0
    identificadorModal = 0
    $("#dtRecibo").val(formatDate(new Date(), 'en'))
})


$("#parcel").change(function (e) {
    if ($(this).is(':checked')) {
        $("#totalParcels").attr('disabled', false)
        $('#totalParcels').val("1")
        listParcels(1)
    } else {
        $('#totalParcels').val("")
        $("#totalParcels").attr('disabled', true)
        listParcels(0)
    }

})



$("#totalParcels").focusout(function () {
    if ($(this).val() > 12) {
        $("#totalParcelshelp").text('Número de parcelas não pode ser maior que 12')
        $(this).val(0)
        return
    }
    $("#totalParcelshelp").text('')
    var totalParcels = Number($(this).val())
    listParcels(totalParcels)
})

function listParcels(totalParcels) {
    $("#gridParcels").html('');
    var i = 1;
    var dateInlude = $("#dtRecibo").val()
    var totalCard = Number($("#valPayCard").val())

    var data = new Date(dateInlude);

    var dinheiro =
        console.log(dinheiro);
    console.log(data.getDate());

    while (i <= totalParcels) {
        const dataSum = i == 1 ? data.setDate(data.getDate() + 1) : data.setDate(data.getDate() + 30);
        var numFloat = Number(parseFloat(totalCard / totalParcels).toFixed(2))

        $("#gridParcels").append(`
        <tr class="text-center" >
        <td>${i}</td>
        <td>${numFloat.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })}</td>
        <td>${formatDate(new Date(dataSum), 'pt')}</td>
        `)
        i++
    }
}



function formatDate(date, format) {
    var year = date.getFullYear()
    var month = date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1
    var day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
    $('#dtRecibo').attr('min', (year - 1) + '-' + month + '-' + day)

    if (format == 'en') {
        return year + '-' + month + '-' + day
    }
    return day + '-' + month + '-' + year

}


$("#formPagamento").on('click', function () {
    if ($('#cmbStatus').val().length > 0 && identificadorPac != 0) {

        $("#modalPagamentos").modal('show')
    } else {
        $("#tpModal").addClass('modal-danger')
        $("#btTpModal").addClass('btn-outline-danger')
        $("#messageModal").text('Por favor selecione o paciente e o procedimento para continuar! ')
        $("#modalMessage").modal('show')
    }
})