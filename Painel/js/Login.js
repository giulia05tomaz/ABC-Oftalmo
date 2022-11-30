// Post para autenticar Login
function login() {
    //Verifica se o e-mail e senha estão prenchidos
    if ($('#usuarioForm').val() == "" || $('#senhaForm').val() == "") {
        $('#ModalErroUserSenha').modal('show');
    } else {
        //Retorna os dados do form

        var userLogin = $('#usuarioForm').val()
        var senhaLogin = $('#senhaForm').val()
        //Conecta com o metodo post de autenticação
        $.ajax({
            type: "POST",
            url: "./web_services/ws-login.php/authenticate",
            data: { userLogin, senhaLogin },
            success: function (response) {

                if (response == "1") {
                    window.location.replace('./Home.php')
                } else if (response == 4) {
                    $("#tpModal").addClass('modal-danger')
                    $("#btTpModal").addClass('btn-outline-danger')
                    $("#messageModal").text('Você foi bloquado por muitas tentativas')
                    $("#modalMessage").modal('show')
                } else if (response == 5) {
                    $("#tpModal").addClass('modal-warning')
                    $("#btTpModal").addClass('btn-outline-warning')
                    $("#messageModal").text('Por favor verifique seus dados')
                    $("#modalMessage").modal('show')
                } else if (response == 6) {
                    $("#tpModal").addClass('modal-warning')
                    $("#btTpModal").addClass('btn-outline-warning')
                    $("#messageModal").text('Usuário encontra-se inativo')
                    $("#modalMessage").modal('show')
                }

                else {
                    $("#tpModal").addClass('modal-warning')
                    $("#btTpModal").addClass('btn-outline-warning')
                    $("#messageModal").text('Por favor verifique seus dados')
                    $("#modalMessage").modal('show')
                }

            }
        });
    }
}




$('#ForgetPassword').click(() => {
    $('#ModalEsqueciSenha').modal('show');
})


function recoverPass() {
    if ($('#RecEmail').val() == "") {
        $('#ModalErroUserSenha').modal('show');
    } else {
        $.ajax({
            type: "POST",
            url: "./web_services/ws-login.php/recoverPass",
            data: JSON.stringify({ email: $('#RecEmail').val() }),
            success: function (response) {
                console.log(response)
                $("#modalCadUsuarios").modal('hide')
            }
        })
    }


}