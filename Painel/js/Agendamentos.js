
var colorStatus = {
    emAtend: "#9932CC",
    agendado: "#FFA500",
    confirm: "#0000FF",
    atendido: "#32CD32",
    cancelado: "#FF0000",
}
var click = false
// executaTabelaPacientes()
var clickPac = 0
var identificadorModal = 0
var identificadorPac = 0

var dateAtual = new Date()
var year = dateAtual.getFullYear()
var month = dateAtual.getMonth() < 10 ? '0' + (dateAtual.getMonth() + 1) : dateAtual.getMonth() + 1
var day = dateAtual.getDate() < 10 ? '0' + dateAtual.getDate() : dateAtual.getDate()




$("#flatpickrConsult").flatpickr({
    "enableTime": false,
    "dateFormat": "d-m-Y",
    "inline": true,
    "locale": 'pt',
    onChange: function (selectedDates, dateStr, instance) {
        console.log(formatDate(selectedDates[0].toISOString().split('T')[0], 'pt'))
        clickPac = 0
        listaDadosTable(formatDate(selectedDates[0].toISOString().split('T')[0], 'pt'))
    },

});
$("#dataAgendamento").flatpickr({
    "enableTime": false,
    "dateFormat": "d-m-Y",
    "locale": 'pt',
    "minDate": day + '-' + month + '-' + year,
    onChange: function (selectedDates, dateStr, instance) {
        // console.log(formatDate(selectedDates[0].toISOString().split('T')[0], 'en'))

        // listaDadosTable(selectedDates[0].toISOString().split('T')[0], 'en')
    },

});




function executaTabelaHome() {
    $('#listasJquery').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJquery').DataTable({
        scrollY: '60vh',
        scrollCollapse: true,
        heigth: '200px',
        lengthMenu: [20, 50, 70, 100],
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


$(".flatpickr ").val(day + '-' + month + '-' + year)
// $("#dataAgendamento").val(day + '-' + month + '-' + year)
$("#filterAgenda").val(year + '-' + month + '-' + day)
$("#filterAgendaFim").val(year + '-' + month + '-' + day)
// $('#dataAgendamento').attr('min', day + '-' + month + '-' + year)

function listaDadosTable(date) {


    var JsonEnvio = {
        roomLocation: window.location.search.replace('?room=', ''),
        days1: clickPac == 1 ? '1900-01-01' : formatDate(date, 'en'),
        days2: clickPac == 1 ? '2300-01-01' : formatDate(date, 'en'),
        idPac: clickPac == 1 ? identificadorPac : 0
    }



    $("#observacaoAgenda").val('')
    $('#listasJquery').DataTable().destroy();
    $("#gridHome").html('')



    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/listAgendamentos",
        data: JSON.stringify(JsonEnvio),
        beforeSend: function (response) {
            $('body').css({ 'overflow': 'visible' });
            $('#preloader .inner').fadeIn();
            $('#preloader').fadeIn('slow');
        },
        success: function (response) {

            var jsonListar = JSON.parse(response)
            if (jsonListar.length < 1) {
                executaTabelaHome()
                $('#preloader .inner').delay(1000).fadeOut();
                $('#preloader').delay(1000).fadeOut('slow');
                $('body').delay(1000).css({ 'overflow': 'visible' });
                return;
            }
            jsonListar.map((item, index) => {

                $('#gridHome').append(`
                <tr class="text-center" >
                  <td  class="text-center m-0 ssWrap">${item.dataAgendamento}</td>
                  <td  class="text-center m-0 ssWrap">${item.hrAgendamento}</td>
                  <td  class="text-center m-0 ssWrap">${item.tpAgendamento}</td>
                  <td  class="text-center m-0 ssWrap">${item.nomePacAgendamento}</td>
                  <td  class="text-center m-0 ssWrap">${item.obsAgendamento}</td>
                  <td  class="text-center m-0 ssWrap">  
                  <div class="form-row">
                 
                  <div class="form-group col-md-8 col-lg-8  m-0">
                  <select  class="custom-select customStatusAgenda" name="${item.identificador}" id="statusAGD">
                  <option value=""></option>
                  
                  <option value="emAtend" ${item.statusA == 'emAtend' ? 'selected' : ''}>EM ATENDIMENTO</option>
                  <option value="agendado" ${item.statusA == 'agendado' ? 'selected' : ''}>AGENDADO</option>
                  <option value="confirm" ${item.statusA == 'confirm' ? 'selected' : ''}>CONFIRMADO POR TELEFONE</option>
                  <option value="atendido" ${item.statusA == 'atendido' ? 'selected' : ''}>ATENDIDO</option>
                  <option value="cancelado" ${item.statusA == 'cancelado' ? 'selected' : ''}>CANCELADO</option>
                  </select>
                  </div>
              
                  <div class="  form-group col-md-2 col-lg-2  m-0">
                  <i style="color: ${colorStatus[item.statusA]};" id="${item.identificador + item.identificador}" class=" iconStatus fas fa-check-circle  fa-2x"></i>
                 
                  </div>
                  <div class="form-group col-md-1 col-lg-1  m-0"></div>
                  </div>
                            </td>

                  <td class="text-center m-0 ">
                    <button type="button" class="btn btn-darkblue btn-custom-w alteraAgendamento"  id = "${item.identificador}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                    <button type="button" class="btn btn-danger btn-custom-w deletarAgenda"  id="${item.identificador}"><i class="fas fa-trash fa-lg fa-spacing"></i></button>
                    <button type="button" class="btn btn-darkblue btn-custom-w gotoRecibo"  id="${item.identificadorPac}"> <i class="fas fa-print fa-lg fa-spacing"></i></i></button>
                    </td>
                </tr>
               
                `)
            })
            executaTabelaHome()

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

$(document).on('click', '.deletarAgenda', function () {
    identificadorModal = $(this).attr('id')
    $("#deletaPaciente").modal('show')
})

$(document).on('click', '.gotoRecibo', function () {
    window.location = './Recibos.php' + window.location.search + '&idAgenda=' + $(this).attr('id')
})

$(document).on('change', '.customStatusAgenda', function () {
    $(`#${$(this).attr('name')}${$(this).attr('name')}`).css({ 'color': colorStatus[this.value] })
    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/upStatus",
        data: { identificador: $(this).attr('name'), value: this.value },
        success: function (response) {


        }
    })
})

function deletaAgenda() {


    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/deletaAgendamento",
        data: { identificador: identificadorModal },
        success: function (response) {
            $('#preloader .inner').fadeIn();
            $('#preloader').fadeIn('slow');
            $('body').css({ 'overflow': 'hiden' });
            listaDadosTable($("#flatpickrConsult").val())

        }
    })
}

function filterPacientes() {

    var inputFilter = $("#pesqPaciente").val().replace(/[^A-Za-z0-9 ' ']+/g, "").toUpperCase()

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

        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no cadastro, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })



}

$("#psePaciente").on('click', function () {
    clickPac = 1
})
$("#psePaciente2").on('click', function () {
    clickPac = 0
})

function ClickTr(resolve, name) {
    $("#psePacienteHelper").text('')
    var nomePaciente = $(`#${resolve} td#nomePaciente`).text()
    var CpfPaciente = $(`#${resolve} td#CpfPaciente`).text()
    var dtNascimento = $(`#${resolve} td#dtNascimento`).text()
    var telPaciente = $(`#${resolve} td#telPaciente`).text()
    var celPaciente = $(`#${resolve} td#celPaciente`).text()
    var isConvenio = $(`#${resolve} td#isConvenioLista`).text()
    var nomeConvenio = $(`#${resolve} td#nomeConvenio`).text()
    var dtFormated = dtNascimento.split('/')
    identificadorPac = name
    $("#modalCadAgendamentos").attr('name', resolve)
    $("#modalPesPac").modal('hide')

    $("#namePaciente").val(nomePaciente)
    $("#CpfPaciente").val(CpfPaciente)
    $("#dataNasciPaciente").val(`${dtFormated[2]}-${dtFormated[1]}-${dtFormated[0]}`)
    $("#telPaciente").val(telPaciente)
    $("#celularPaciente").val(celPaciente)
    $("#isConvenioModal").val(isConvenio)
    $("#nomeConvenio").val(nomeConvenio)
    if (clickPac == 1) {
        listaDadosTable()
    } else {
        clickPac = 0
    }


}
listaDadosTable(day + '-' + month + '-' + year)
//masks
$('#telPaciente').mask('(00)00000-0000');
$('#celularPaciente').mask('(00)00000-0000');
$('#RgPaciente').mask('00.000.000-0');
$('#CpfPaciente').mask('000.000.000-00');
$('#CepPaciente').mask('00000-000');




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

function cadastraAgendamento(med) {


    const validFild = validFields()
    if (!validFild) {

        return;
    }
    $("small.text-danger").text('')
    let objObs = [];
    let dateAtual = new Date();
    let fullYear = dateAtual.getFullYear();
    let monthAtual = dateAtual.getMonth() + 1;
    let dayAtual = dateAtual.getDate();

    // Coloca as observações em um objeto
    $('#obsAfast textarea.txtObs').each(function () {
        if ($(this).val() != '') {
            let json = {
                observacao: $(this).val().toUpperCase(),
                dataObs:
                    (dayAtual <= 9 ? '0' + dayAtual : dayAtual) +
                    '-' +
                    (monthAtual <= 9 ? '0' + monthAtual : monthAtual) +
                    '-' +
                    fullYear,
            };
            objObs.push(json);

        }
    });

    var jsonAgendamento = {
        identificadorPac: identificadorPac,
        identificadorAgd: identificadorModal,
        dataAgendamento: formatDate($("#dataAgendamento").val(), 'en'),
        hrAgendamento: $("#hrAgendamento").val(),
        tpConsulta: $("#tpConsulta").val().toUpperCase(),
        confirmadoConsulta: $("#confirmadoConsultaModal").val().toUpperCase(),
        observacaoAgenda: $("#observacaoAgenda").val().toUpperCase(),
        obsmedico: objObs,
        roomLocation: window.location.search.replace('?room=', ''),
        arrayProcedimentos: null,
        med: med
    }

    var pushProcedimentos = []

    if ($('#cmbStatus').val().length > 0) {

        $('#cmbStatus option').each(function () {
            if ($(this).is(":checked")) {

                pushProcedimentos.push(Number(this.id))
            }
        })

        jsonAgendamento['arrayProcedimentos'] = pushProcedimentos
    } else {
        jsonAgendamento['arrayProcedimentos'] = []
    }


    var button = $("#cadastrarAgendamento").text()

    $.ajax({
        type: "POST",
        url: `./web_services/ws-agendamentos.php/${button == "ALTERAR" ? 'updateAgendamento' : 'gravaAgendamento'}`,
        data: JSON.stringify(jsonAgendamento),
        success: function (response) {

            if (response == "invalid") {
                $("#tpModal").addClass('modal-warning')
                $("#btTpModal").addClass('btn-outline-warning')
                $("#messageModal").text('Horário de agendamento inválido, insira intervalo de 30 em 30 minutos! ')


                $("#modalMessage").modal('show')
                return
            }
            $("#tpModal").addClass('modal-success')
            $("#btTpModal").addClass('btn-outline-success')
            $("#messageModal").text('Dados gravados com sucesso! ')

            $("#modalCadAgendamentos").modal('hide')
            $("#modalMessage").modal('show')
            clickPac = 0
            listaDadosTable($("#dataAgendamento").val())
            $("#flatpickrConsult").val($("#dataAgendamento").val())
        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro no requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
}

function validFields() {
    if (identificadorPac == 0) {

        $("#psePacienteHelper").text("Selecionar um paciente")
        return false
    }
    if ($("#tpConsulta").val() == '') {
        $("#tpConsultaHelpCad").text("Preencha este campo")
        return false
    } else if ($("#confirmadoConsultaModal").val() == '') {
        $("#confirmadoHelpCad").text("Preencha este campo")
        return false
    } else if ($("#dataAgendamento").val() == '') {
        $("#dataAgeaHelpCad").text("Preencha este campo")
        return false
    } else if ($("#hrAgendamento").val() == "" || $("#hrAgendamento").val() == '00:00:00') {
        $("#hrAgendHelpCad").text("Preencha este campo")
        return false
    }
    return true
}

function cleanSmall(id) {
    $("#" + id).text('')
}

$(document).on('click', '.alteraAgendamento', function () {
    $("#finAgenda").css({
        'display': 'block'
    })
    identificadorModal = $(this).attr('id')
    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/infoAgendamento",
        data: { identificadorModal },
        success: function (response) {
            var jsonResponse = JSON.parse(response)
            var jsonProcedimentos = JSON.parse(jsonResponse.fkProcedimentos)
            var selecteds = []
            let arrayObs =
                jsonResponse.obsProntuario == '' || jsonResponse.obsProntuario == null
                    ? null
                    : JSON.parse(jsonResponse.obsProntuario?.replace(/(?:\\[rn]|[\r\n]+)+/g, " "));

            identificadorPac = jsonResponse.paciente

            $("#dataAgendamento").val(jsonResponse.dataAgendamento)
            $("#hrAgendamento").val(jsonResponse.HoraAgendamento)
            $("#tpConsulta").val(jsonResponse.tipoAgendamento)
            $("#confirmadoConsultaModal").val(jsonResponse.confirmaAgendamento)
            $("#namePaciente").val(jsonResponse.namePaciente)
            $("#CpfPaciente").val(jsonResponse.cpfPaciente)
            $("#dataNasciPaciente").val(jsonResponse.dataNascimentoPaciente)
            $("#telPaciente").val(jsonResponse.telefonePaciente)
            $("#celularPaciente").val(jsonResponse.celularPaciente)
            $("#isConvenioModal").val(jsonResponse.convenioPaciente)
            $("#nomeConvenio").val(jsonResponse.nameConvPaciente)
            $("#observacaoAgenda").val(jsonResponse.observacao)


            if (arrayObs != '' && arrayObs != null) {
                $('#obsAfast').html('');
                arrayObs.map((item, index) => {
                    $('#obsAfast').append(`
                                  <div class="form-row campoObs">
                                    <textarea class="form-control txtObs caps" rows="3" placeholder="Digite uma observação" style="width: 95%;" readonly="true">${item.observacao}</textarea>
                                   
                                    <p id="dataObs">Data da Observação: ${item.dataObs}</p>
                                  </div>
                              `);
                });
            }
            if (jsonProcedimentos.length > 0) {

                jsonProcedimentos.map(function (item, index) {

                    selecteds.push(item)


                })

                selecteds.map(function (item, index) {
                    $(`#cmbStatus option[id='${item}']`).prop('selected', true)

                })
                $('.selectpicker').selectpicker('refresh');
            }



            $("#cadastrarAgendamento").text('ALTERAR')
            $("#modalCadAgendamentos").modal('show')
        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro na requisição, tente novamente! ')
            $("#modalMessage").modal('show')
        }
    })
})

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


$('#modalCadAgendamentos').on('hidden.bs.modal', function (e) {
    $("#finAgenda").css({
        'display': 'none'
    })
    $('.selectpicker').selectpicker('deselectAll');
    $("#modalCadAgendamentos input").val('')
    $(".selectAgd").val('')
    $("#cadastrarAgendamento").text('CADASTRAR')
    $("#modalCadAgendamentos").modal('hide')
    $('.checkboxList').prop('checked', false);
    $(".dropdown-check-list").removeClass('visible')
    identificadorPac = 0
    identificadorModal = 0
    $('#obsAfast').html('')
    $('#obsAfast').append(` <div class="form-row campoObs" id="divtextArea-0">
    <textarea id="textArea-0" class="form-control txtObs caps" rows="3" placeholder="Digite uma observação" style="width: 90%;"></textarea>
    <!-- <button type="button" class="btn color-red btn-custom-vk" onclick="del_obs_cad(event, divtextArea-0)"><i class="fas fa-trash fa-lg fa-spacingDelete"></i></button> -->
    <span class="errorTextArea">Adcione um texto</span>
</div>
`)
})


$(".page-link").on('click', function () {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".h3menu").offset().top - 70
    }, 3000);
})


// atualizar()
$('#filterAgenda').focusout(function () {
    var dateAtual = year + '-' + month + '-' + day

    if ($('#filterAgenda').val().length > 9 && $('#filterAgenda').val() != dateAtual) {
        clickPac = 0
        listaDadosTable(formatDate($("#dataAgendamento").val(), 'en'))
    }
})





var idsTextArea = 1
function add_obs_cad(id) {

    $('#obsAfast').append(`
<div class="form-row campoObs mt-3 " id="divtextArea-${idsTextArea}">
<textarea id="textArea-0" class="form-control txtObs caps" rows="3" placeholder="Digite uma observação" style="width: 90%;"></textarea>
<button type="button" class="btn color-red btn-custom-vk" onclick="del_obs_cad( 'divtextArea-${idsTextArea}')"><i class="fas fa-trash fa-lg fa-spacingDelete"></i></button>
<span class="errorTextArea">Adcione um texto</span>
</div>
`)
    idsTextArea++
}

// del observação
function del_obs_cad(id) {
    $('#' + id).remove()
    idsTextArea--;
}


function getfUNCTION() {
    click = true
}

function formatDate(date, format) {
    var dateSplit = date.split('-')
    var year = dateSplit[2]
    var month = dateSplit[1]
    var day = dateSplit[0]

    if (format == 'en') {
        return year + '-' + month + '-' + day
    }
    return dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0]

}
