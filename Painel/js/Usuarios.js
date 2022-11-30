function executaTabelaUsers() {
    $('#listasJqueryUsuarios').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listasJqueryUsuarios').DataTable({

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
executaTabelaUsers()

$('#rowDesblock').css({ 'display': 'none' });

var identificadorCad = 0
function listaDadosTable() {
    $('#listasJqueryUsuarios').DataTable().destroy();
    $('#gridUsuarios').html('')


    $.ajax({
        type: "GET",
        url: "./web_services/ws_user.php/listusers",
        success: function (response) {

            var jsonResponse = JSON.parse(response)
            jsonResponse.map((item, index) => {
                $('#gridUsuarios').append(`
                <tr class="text-center">
              <td>${item.nomeusuario}</td>
              <td>${item.emailusuario}</td>
              <td>${item.nivelUsuario == 1 ? "Médico" : item.nivelUsuario == 2 ? "Administrador" : "Atendente"}</td>
              <td>${item.statusUser == 1 ? "Ativo" : "Inativo"}</td>

              <td class="text-center">
                <button type="button" class="btn btn-darkblue btn-custom-w alteraPerfil" id="${item.identificadorUsers}"><i class="fas fa-pen fa-lg fa-spacing"></i></button>
                <button type="button" class="btn btn-danger btn-custom-w deletaRegistro"  id="${item.identificadorUsers}"><i class="fas fa-trash fa-lg fa-spacing"></i></button>
                </td>
            </tr>
                `)
            })

            executaTabelaUsers()
            $('#preloader .inner').delay(1000).fadeOut();
            $('#preloader').delay(1000).fadeOut('slow');
            $('body').delay(1000).css({ 'overflow': 'visible' });
        }
    })


}

listaDadosTable()
//masks


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
$(document).on('click', '.alteraPerfil', function () {
    $('#rowDesblock').css({ 'display': 'block' });
    $("#cadUser").text('ALTERAR')
    identificadorCad = $(this).attr('id')
    $('#modalCadUsuarios').modal('show')
    $("#modalCadUsuarios").attr("name", identificadorCad)
    $.ajax({
        type: "POST",
        url: "./web_services/ws_user.php/informationUser",
        data: { identificador: identificadorCad },
        success: function (response) {

            var jsonResponse = JSON.parse(response)
            $("#nameLogin").val(jsonResponse.loginUser)
            $("#nameUser").val(jsonResponse.nameUser)
            $("#emailUser").val(jsonResponse.emailUser)
            $("#statusUser").val(jsonResponse.statusUser)
            $("#nvUser").val(jsonResponse.nvUser)

        }, error: function () {
            $("#tpModal").addClass('modal-danger')
            $("#btTpModal").addClass('btn-outline-danger')
            $("#messageModal").text('Erro na requisição tente novamente')
            $("#modalMessage").modal('show')
        }
    })

})

function gravaUsuarios() {
    var textbtn = $("#cadUser").text()
    var jsonEnvio = {
        nameLogin: $("#nameLogin").val(),
        passwordUser: $("#passwordUser").val(),
        nameUser: $("#nameUser").val(),
        emailUser: $("#emailUser").val(),
        statusUser: $("#statusUser").val(),
        nvUser: $("#nvUser").val(),

    }

    if (textbtn == 'ALTERAR' && jsonEnvio['passwordUser'].length < 2) {
        delete jsonEnvio['passwordUser']
    }

    var validCampos = 0
    $.each(jsonEnvio, function (item, value) {
        if (!value || value == " ") {
            $(`#${item}Span`).text('Por favor preencha este campo')
            validCampos = 1
            return false;
        } else {
            validCampos = 0
            $(`#${item}Span`).text('')
        }
    })

    if (textbtn == 'ALTERAR') {
        jsonEnvio['identificador'] = $("#modalCadUsuarios").attr("name")
    }
    if (validCampos != 1) {
        $.ajax({
            type: "POST",
            url: `./web_services/ws_user.php/${textbtn == 'CADASTRAR' ? 'gravaUsers' : 'alteraUsers'}`,
            data: JSON.stringify(jsonEnvio),
            success: function (response) {

                if (response == "userExiste") {
                    $("#tpModal").addClass('modal-warning')
                    $("#btTpModal").addClass('btn-outline-warning')
                    $("#messageModal").text('Usuário ou email já existe na base de dados ')
                    $("#modalMessage").modal('show')
                } else {
                    $("#tpModal").addClass('modal-success')
                    $("#btTpModal").addClass('btn-outline-success')
                    $("#messageModal").text('Dados gravados com sucesso')
                    $("#modalCadUsuarios").modal('hide')
                    $("#modalMessage").modal('show')
                    listaDadosTable()
                }




            }, error: function () {
                $("#tpModal").addClass('modal-danger')
                $("#btTpModal").addClass('btn-outline-danger')
                $("#messageModal").text('Erro na requisição tente novamente')
                $("#modalMessage").modal('show')
            }
        })
    }
}

$(document).on('click', '.deletaRegistro', function () {
    identificadorCad = $(this).attr('id')
    $("#deletaPaciente").modal('show')
})

function deletaUsuarios() {
    $.ajax({
        type: "POST",
        url: "./web_services/ws_user.php/deletaUsuarios",
        data: { identificador: identificadorCad },
        success: function (response) {
            listaDadosTable()
        }
    })
}

$('#modalCadUsuarios').on('hidden.bs.modal', function (e) {
    $('#rowDesblock').css({ 'display': 'none' });
    $("input").val('')
    $(".selectUser").val('')

    $("#modalCadUsuarios").modal('hide')
    $("#modalCadUsuarios").removeAttr('name')
    $("#cadUser").text('CADASTRAR')
})

var generatePassword = function () {
    var numLc = 2;
    var numUc = 2;
    var numDigits = 4;
    var numSpecial = 2;


    var lcLetters = 'abcdefghijklmnopqrstuvwxyz';
    var ucLetters = lcLetters.toUpperCase();
    var numbers = '0123456789';
    var special = '!?=#*$@{}[]<>';

    var getRand = function (values) {
        return values.charAt(Math.floor(Math.random() * values.length));
    }

    //+ Jonas Raoni Soares Silva
    //@ http://jsfromhell.com/array/shuffle [v1.0]
    function shuffle(o) { //v1.0
        for (var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    };

    var pass = [];
    for (var i = 0; i < numLc; ++i) { pass.push(getRand(lcLetters)) }
    for (var i = 0; i < numUc; ++i) { pass.push(getRand(ucLetters)) }
    for (var i = 0; i < numDigits; ++i) { pass.push(getRand(numbers)) }
    for (var i = 0; i < numSpecial; ++i) { pass.push(getRand(special)) }

    var pass = shuffle(pass).join('');
    $('#passwordUser').val(pass);
    // $('#cadAltSenhaForm').val(pass);
}

function desblockUser() {
    $.ajax({
        type: "POST",
        url: "./web_services/ws_user.php/desbloqueioUser",
        data: { identificador: identificadorCad },
        success: function (response) {
            $("#modalCadUsuarios").modal('hide')
        }
    })
}


// generatePassword()