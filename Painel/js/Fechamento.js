function executaTabelaFechamento() {
    $('#listasJqueryFechamentos').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJqueryFechamentos').DataTable({
        scrollY: '60vh',
        scrollCollapse: true,
        heigth: '200px',
        lengthMenu: [10, 20, 50, 70],
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
var dateAtual = new Date()

var year = dateAtual.getFullYear()
var month = dateAtual.getMonth() < 10 ? '0' + (dateAtual.getMonth() + 1) : dateAtual.getMonth() + 1
var day = dateAtual.getDate() < 10 ? '0' + dateAtual.getDate() : dateAtual.getDate()
$("#dtRecibo").val(year + '-' + month + '-' + day)
$("#filterAgenda").val(year + '-' + month + '-' + day)
$("#filterAgendaFim").val(year + '-' + month + '-' + day)

function listaDadosTable() {


    $('#listasJqueryFechamentos').DataTable().destroy();
    $("#gridFechamentos").html('')

    var JsonEnvio = {
        roomLocation: window.location.search.replace('?room=', ''),
        days1: $("#filterAgenda").val(),
        days2: $("#filterAgendaFim").val(),
    }
    $('#preloader .inner').delay(1000).fadeOut();
    $('#preloader').delay(1000).fadeOut('slow');
    $('body').delay(1000).css({ 'overflow': 'visible' });

    $.ajax({
        type: "POST",
        url: "./web_services/ws-fechamento.php/listFechamento",
        data: JSON.stringify(JsonEnvio),
        success: function (response) {

            var jsonListar = JSON.parse(response)
            if (jsonListar.length < 1) {
                executaTabelaFechamento()
                $('#preloader .inner').delay(1000).fadeOut();
                $('#preloader').delay(1000).fadeOut('slow');
                $('body').delay(1000).css({ 'overflow': 'visible' });
                return;
            }
            jsonListar.map((item, index) => {

                $('#gridFechamentos').append(`
                <tr class="text-center" >
                  <td>${item.identificador}</td>
                  <td>${item.namePac}</td>
                  <td>${item.parc}</td>
                  <td>${item.dataAtualInclude}</td>
                  <td>${Number(item.total).toFixed(2)}</td>
                  <td>${Number(item.totalRcb).toFixed(2)}</td>
                  
                </tr>
               
                `)
            })
            executaTabelaFechamento()
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

var dateAtual = year + '-' + month + '-' + day

$('#filterAgenda').focusout(function () {

    if ($('#filterAgenda').val().length > 9 && $('#filterAgenda').val() != dateAtual) {
        if ($('#filterAgenda').val() > $('#filterAgendaFim').val()) {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('A primeira data não pode ser maior que a primeira data ! ')
            $("#modalMessage").modal('show')
            $("#filterAgenda").val(year + '-' + month + '-' + day)
            return
        }
        listaDadosTable()


    }
})
$('#filterAgendaFim').focusout(function () {
    if ($('#filterAgendaFim').val().length > 9 && $('#filterAgenda').val() != dateAtual) {
        if ($('#filterAgenda').val() > $('#filterAgendaFim').val()) {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('A primeira data não pode ser maior que a primeira data ! ')
            $("#modalMessage").modal('show')
            $("#filterAgenda").val(year + '-' + month + '-' + day)
            return;
        }
        listaDadosTable()


    }
})
listaDadosTable()

