

$(document).on('click', '.dismisToast', function () {


    // $.ajax({
    //     type: "POST",
    //     url: "./web_services/ws-agendamentos.php/updateAgendaIsAgenda",
    //     success: function (response) {
    //         $("#ToastGlobal").html('')
    //     }
    // })
    $(".toast").toast('hide')
})

var loaded = false
function verifyAgenda() {

    $.ajax({
        type: "POST",
        url: "./web_services/ws-agendamentos.php/verifyAgendamento",
        success: function (response) {
            $("#ToastGlobal").html('')
            var jsonResponse = JSON.parse(response)


            if (jsonResponse.length > 0) {
                $("#numberAgendas").text(jsonResponse[0].numberAgendas)
                jsonResponse.map((item, index) => {
                    $("#ToastGlobal").append(`
                    <div class="bs-example dismisToastoo"    style="position: absolute;right: 40px;top:100px">

                    <div class="toast fade show">
                    <div class="toast-header btn-warning">
                    <strong class="mr-auto "><i class="fas fa-exclamation-triangle text-white"></i> Atenção!</strong>
                    
                    <button type="button" class="ml-2 mb-1 close  dismisToast  text-white" id="dismisToast${index}"  data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body btn-white">Um novo agendamento foi realizado no dia ${item.dataAgendamento}</div>
                    </div>
                    </div>
                    `)

                })
            } else {
                $("#numberAgendas").text(0)
            }


        }
    })
}

setInterval(() => {
    verifyAgenda()
}, 5000)