

function executaTabelaHome() {
    $('#listasJquery').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJquery').DataTable({
        scrollY: '50vh',
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

function listaDadosTable() {




    $("#observacaoAgenda").val('')
    $('#listasJquery').DataTable().destroy();
    $("#gridHome").html('')



    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/listAgendamentosNew",
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
                $("#numberAgendas").text(jsonListar[0].numberAgendas)
                $('#gridHome').append(`
                <tr class="text-center" >
                  <td>${item.dataAgendamento}</td>
                  <td>${item.hrAgendamento}</td>
                  <td>${item.tpAgendamento}</td>
                  <td>${item.nomePacAgendamento}</td>
                  <td>${item.obsAgendamento}</td>
                   <td class="text-center">
  
                   <button type="button" class="btn btn-darkorange btn-custom-w alteraAgendamento"  id = "${item.identificador}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                    <button type="button" class="btn btn-darkblue btn-custom-w updateAgenda"  id = "${item.identificador}"><i class="fas fa-check-circle fa-lg fa-spacing"></i></button>
                   
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

listaDadosTable()

$(document).on('click', '.updateAgenda', function () {


    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/updateAgendaIsAgendaNew",
        data: JSON.stringify({ id: $(this).attr('id') }),
        success: function (response) {
            listaDadosTable()
        }
    })

})


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
                    : JSON.parse(jsonResponse.obsProntuario);

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