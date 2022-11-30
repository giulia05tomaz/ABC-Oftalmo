$(window).on('load', function () {
    $('#observacaoAgenda').val('')
})


var dateAtual = new Date()
var year = dateAtual.getFullYear() - 2
var month = dateAtual.getMonth() < 10 ? '0' + (dateAtual.getMonth() + 1) : dateAtual.getMonth() + 1
var day = dateAtual.getDate() < 10 ? '0' + dateAtual.getDate() : dateAtual.getDate()


$('input[type="date"]').attr('min', year + '-' + month + '-' + day)

function executaTabelaHome() {
    $('#listasJqueryPacientes').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJqueryPacientes').DataTable({

        lengthMenu: [25, 50, 75, 100],
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
executaTabelaHome()


function listaDadosTable() {


    $('#listasJqueryPacientes').DataTable().destroy();
    $('#gridPacientes').html('')

    $.ajax({
        type: "GET",
        url: "./web_services/ws-pacientes.php/listPacientes",
        // beforeSend: function (response) {
        //     $('body').css({ 'overflow': 'visible' });
        //     $('#preloader').css({ 'position': 'fixed' });
        //     $('#preloader .inner').delay(1000).fadeIn();
        //     $('#preloader').delay(1000).fadeIn('slow');
        // },
        success: function (response) {

            var jsonListar = JSON.parse(response)
            if (jsonListar.length < 1) {
                $('#preloader .inner').delay(1000).fadeOut();
                $('#preloader').delay(1000).fadeOut('slow');
                $('body').delay(1000).css({ 'overflow': 'visible' });
                executaTabelaHome()
                return;
            }
            jsonListar.map((item, index) => {
                $('#gridPacientes').append(`
                    <tr class="text-center ssWrap">
                      <td class=" ssWrap">${item.nomePaciente}</td>
                      <td class=" ssWrap">${item.CpfPaciente}</td>
                      <td class=" ssWrap">${item.rgPaciente}</td>
                      <td class=" ssWrap">${item.dtNascimento}</td>
                      <td class=" ssWrap">${item.telPaciente}</td>
                      <td class=" ssWrap">${item.celpaciente}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-darkblue btn-custom-w alteraPerfil"  id="${item.identificadorPac}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                        <button type="button" class="btn btn-danger btn-custom-w deletaUser"  id="${item.identificadorPac}"><i class="fas fa-trash fa-lg fa-spacing"></i></button>
                      </td>
                    </tr>
                    `)
            })

            executaTabelaHome()
            $('#preloader .inner').delay(1000).fadeOut();
            $('#preloader').delay(1000).fadeOut('slow');
            $('body').delay(1000).css({ 'overflow': 'visible' });

        }, error: function () {

        }
    })



}


listaDadosTable()
//masks
$('#telPaciente').mask('(00)00000-0000');
$('#celularPaciente').mask('(00)00000-0000');
$('#RgPaciente').mask('00.000.000-0');
$('#CpfPaciente').mask('000.000.000-00');
$('#CepPaciente').mask('00000-000');
var identificadorCad = 0;
function gravarPaciente() {
    var JsonEnvio = {
        namePaciente: $("#namePaciente").val().toUpperCase(),
        telPaciente: $("#telPaciente").val().toUpperCase(),
        celularPaciente: $("#celularPaciente").val().toUpperCase(),
        CpfPaciente: $("#CpfPaciente").val().toUpperCase(),
        RgPaciente: $("#RgPaciente").val().toUpperCase(),
        emailPaciente: $("#emailPaciente").val().toUpperCase(),
        dataNasciPaciente: $("#dataNasciPaciente").val().toUpperCase(),
        CepPaciente: $("#CepPaciente").val().toUpperCase(),
        EndPaciente: $("#EndPaciente").val().toUpperCase(),
        cidadePaciente: $("#cidadePaciente").val().toUpperCase(),
        EstadoPaciente: $("#EstadoPaciente").val().toUpperCase(),
        BairroPaciente: $("#BairroPaciente").val().toUpperCase(),
        NumeroPaciente: $("#NumeroPaciente").val().toUpperCase(),
        isConvenio: $("#isConvenio").val() == "" ? "NAO" : $("#isConvenio").val().toUpperCase(),
        nomeConvenio: $("#nomeConvenio").val() == "" ? "SEM CONVENIO" : $("#nomeConvenio").val().toUpperCase(),
        observacaoAgenda: $("#observacaoAgenda").val().toUpperCase(),

        identificador: identificadorCad
    }
    if (JsonEnvio.namePaciente == "") {
        $("#namePacienteHelper").text('Necesário preencher este campo')
        return;
    }
    var button = $('#ConfCadTrab').text().toUpperCase()
    $("small.text-danger").text('')
    $.ajax({
        type: "POST",
        url: `./web_services/ws-pacientes.php/${button == "ALTERAR" ? 'alterarPaciente' : 'gravaPacientes'}`,
        data: JSON.stringify(JsonEnvio),
        success: function (response) {

            if (response == "userExiste") {
                $("#tpModal").addClass('modal-warning')
                $("#btTpModal").addClass('btn-outline-warning')
                $("#messageModal").text('Paciente já existe na base de dados')
                $("#modalMessage").modal('show')
            } else if (response == "update") {
                $("#tpModal").addClass('modal-success')
                $("#btTpModal").addClass('btn-outline-success')
                $("#messageModal").text('Paciente alterado com sucesso')
                $('#modalCadPaciente').modal('hide')
                $("#modalMessage").modal('show')

                $('#preloader').css({ 'position': 'fixed' });
                $('#preloader .inner').fadeIn();
                $('#preloader').fadeIn('slow');
                setTimeout(() => {

                    listaDadosTable()
                }, 1000)

            }
            else {




                $("#tpModal").addClass('modal-success')
                $("#btTpModal").addClass('btn-outline-success')
                $("#messageModal").text('Dados gravados com sucesso')
                $("#modalCadUsuarios").modal('hide')
                $('#modalCadPaciente').modal('hide')
                $("#modalMessage").modal('show')
                $('#preloader').css({ 'position': 'fixed' });
                $('#preloader .inner').fadeIn();
                $('#preloader').fadeIn('slow');
                setTimeout(() => {

                    listaDadosTable()
                }, 1000)
            }


        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no cadastro do paciente, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
}

function getInfoPaciente(identificador) {
    identificadorCad = identificador
    $.ajax({
        type: "POST",
        url: "./web_services/ws-pacientes.php/listaInfopaciente",
        data: { identificador },
        success: function (response) {


            var jsonResponse = JSON.parse(response)
            $("#namePaciente").val(jsonResponse.namePaciente);
            $("#telPaciente").val(jsonResponse.telefonePaciente);
            $("#celularPaciente").val(jsonResponse.celularPaciente);
            $("#CpfPaciente").val(jsonResponse.cpfPaciente);
            $("#RgPaciente").val(jsonResponse.rgPaciente);
            $("#emailPaciente").val(jsonResponse.emailPaciente);
            $("#dataNasciPaciente").val(jsonResponse.dataNascimentoPaciente);
            $("#CepPaciente").val(jsonResponse.cepPaciente);
            $("#EndPaciente").val(jsonResponse.enderecoPaciente);
            $("#cidadePaciente").val(jsonResponse.cidadePaciente);
            $("#EstadoPaciente").val(jsonResponse.estadoPaciente);
            $("#BairroPaciente").val(jsonResponse.bairroPaciente);
            $("#NumeroPaciente").val(jsonResponse.numeroPaciente);
            $("#isConvenio").val(jsonResponse.convenioPaciente);
            $("#nomeConvenio").val(jsonResponse.nameConvPaciente);
            $("#observacaoAgenda").val(jsonResponse.infoComplementares)

            $('#ConfCadTrab').text('alterar')
            $('#modalCadPaciente').modal('show')
        }
    })

}

$(document).on('click', '.alteraPerfil', function () {
    getInfoPaciente($(this).attr('id'))
})
$(document).on('click', '.deletaUser', function () {
    identificadorCad = $(this).attr('id')
    $("#deletaPaciente").modal('show')
})

$(document).on('change', '#CpfPaciente', function () {
    if ($(this).val().length > 12) {
        var cpf = $(this).val().replace(/[^A-Za-z0-9]+/g, "")

        $.ajax({
            type: "POST",
            url: "./web_services/ws-pacientes.php/VerificaPacientes",
            data: JSON.stringify({ cpfpacinte: cpf }),
            success: function (response) {

                if (response == "userExiste") {
                    $("#tpModal").addClass('modal-warning')
                    $("#btTpModal").addClass('btn-outline-warning')
                    $("#messageModal").text('Paciente com este cpf já existe na base de dados')
                    $("#modalMessage").modal('show')
                }

            }
        })
    } else {


        return
    }
})
function deletaPaciente() {


    $.ajax({
        type: "POST",
        url: "./web_services/ws-pacientes.php/deletaPaciente",
        data: { identificador: identificadorCad },
        success: function (response) {
            $('#preloader .inner').fadeIn();
            $('#preloader').fadeIn('slow');
            $('body').css({ 'overflow': 'hiden' });
            listaDadosTable()

        }
    })
}

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

$('#modalCadPaciente').on('hidden.bs.modal', function (e) {
    $('#ConfCadTrab').text('CADASTRAR')
    $(".selectPac").val('')
    $("input").val('')
    $("textarea").val('')
})


