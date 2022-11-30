function logout() {
    $.ajax({
        type: "POST",
        url: "./web_services/ws-logout.php/logout",
        success: function (response) {


            window.location.replace('./Login.php')

        }
    });
}