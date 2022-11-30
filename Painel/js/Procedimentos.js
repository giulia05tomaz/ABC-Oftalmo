function executaTabelaHome() {
    $('#listasJqueryProced').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJqueryProced').DataTable({

        lengthMenu: [10, 25, 50, 75, 100],
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
$('#valPart').mask('####0.00', { reverse: true });
$('#valConv').mask('####0.00', { reverse: true });

function listaDadosTable() {
    $('#listasJqueryProced').DataTable().destroy();
    $('#gridProcedimentos').html('')


    $.ajax({
        type: "GET",
        url: "./web_services/ws_procedimentos.php/listProcedimentos",
        success: function (response) {
            var jsonResponse = JSON.parse(response)
            jsonResponse.map((item, index) => {
                $('#gridProcedimentos').append(`
                <tr class="text-center">
                  <td >${item.descricao} </td>
                  <td>R$ ${item.vaP}</td>
                  <td>R$ ${item.vaC}</td>
                 <td class="text-center">
                    <button type="button" class="btn btn-darkblue btn-custom-w alteraProcedimentos" onclick="tessste('${item}')"  id="${item.identificadorProced}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                    <button type="button" class="btn btn-danger btn-custom-w deletaRegistro"  id="${item.identificadorProced}"><i class="fas fa-trash fa-lg fa-spacing"></i></button>
                    </td>
                </tr>
                `)
            })

            executaTabelaHome()
            $('#preloader .inner').delay(1000).fadeOut();
            $('#preloader').delay(1000).fadeOut('slow');
            $('body').delay(1000).css({ 'overflow': 'visible' });
        }
    })



}




function gravadProced() {

    var jsonEnvio = {
        descricao: $("#descProced").val(),
        valP: $("#valPart").val(),
        valC: $("#valConv").val(),
        identificadorModal: identificadorModal
    }
    var button = $("#ConfCadTrab").text()
    if (!jsonEnvio.descricao) {
        $("#descproced").text("Por favor preencha a descrição")
    } else if (!jsonEnvio.valP) {
        $("#spanValPart").text("Por favor preencha o valor")
    } else if (!jsonEnvio.valC) {
        $("#spanvalConv").text("Por favor preencha o valor")
    } else {

        $.ajax({
            type: "POST",
            url: `./web_services/ws_procedimentos.php/${button == 'ALTERAR' ? 'alteraProcedimentos' : 'gravaProcedimentos'}`,
            data: JSON.stringify(jsonEnvio),
            success: function (response) {

                $("#tpModal").addClass('modal-success')
                $("#btTpModal").addClass('btn-outline-success')
                $("#messageModal").text('Dados gravados com sucesso')
                $("#modalCadProced").modal('hide')
                $("#modalMessage").modal('show')



                listaDadosTable()
            }, error: function () {
                $("#tpModal").addClass('modal-danger')
                $("#btTpModal").addClass('btn-outline-danger')
                $("#messageModal").text('Erro no processamento, por favor tente novamente')
                $("#modalCadProced").modal('hide')
                $("#modalMessage").modal('show')

            }
        })

    }

}

function limpaSpan(id) {
    $(`#${id}`).text('')
}

listaDadosTable()
//masks
$('#telPaciente').mask('(00)00000-0000');
$('#celularPaciente').mask('(00)00000-0000');
$('#RgPaciente').mask('00.000.000-0');
$('#CpfPaciente').mask('000.000.000-00');
$('#CepPaciente').mask('00000-000');

$(document).on('focusout', '#CepPaciente', function () {
    if ($(this).val().length >= 9) {
        const cep = $('#CepPaciente').val().replace(/\D/g, '');
        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
            $("#EndPaciente").val(dados.logradouro)
            $("#BairroPaciente").val(dados.bairro)
            $("#cidadePaciente").val(dados.localidade)
            $("#EstadoPaciente").val(dados.uf)
            $("#NumeroPaciente").focus()
        })
    }
})
$(document).on('click', '.alteraProcedimentos', function () {
    var identificadorProced = $(this).attr('id')
    identificadorModal = identificadorProced
    $.ajax({
        type: "POST",
        url: "./web_services/ws_procedimentos.php/infoProcedimento",
        data: { identificadorProced },
        success: function (response) {
            var jsonResponse = JSON.parse(response)

            $("#descProced").val(jsonResponse.descproced)
            $("#valPart").val(jsonResponse.valParticular)
            $("#valConv").val(jsonResponse.valConvenio)
            $("#ConfCadTrab").text('ALTERAR')
            $("#modalCadProced").modal('show')
        }
    })
})

$('#modalCadProced').on('hidden.bs.modal', function (e) {
    $("#descProced").val('')
    $("#valPart").val('')
    $("#valConv").val('')
    $("#modalCadProced").removeAttr('name')
    $("#ConfCadTrab").text('CADASTRAR')
})


$(document).on('click', '.deletaRegistro', function () {
    identificadorModal = $(this).attr('id')
    $("#deletaPaciente").modal('show')
})

function deletaProcedimentos() {
    $.ajax({
        type: "POST",
        url: "./web_services/ws_procedimentos.php/deletaProcedimentos",
        data: { identificador: identificadorModal },
        success: function (response) {
            listaDadosTable()
        }
    })
}