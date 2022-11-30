<?php include('./includes/head.php') ?>

<body id="bodyHomepac ">
    <ul class="nav " id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" href="./Inicio.php" role="tab" aria-controls="home" aria-selected="true">Início</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" href="" role="tab" aria-controls="profile" aria-selected="false">Histórico</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" href="./Profile.php" role="tab" aria-controls="contact" aria-selected="false">Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="logout" role="tab" data-toggle="modal" data-target="#modalExit" aria-controls="contact" aria-selected="false">Sair</a>
        </li>
    </ul>
    <div>
        <h1 class="text-center">Histórico</h1>
        <div class="p-3 pb-5 mt-4" style="width: 50%; margin: 0 auto;background-color: #f2f5ff;">
            <div class=" mt-2 p-3">
                <div id="listInicio">

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sair</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente sair do sistema ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="logout()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include('./includes/imports.php') ?>

<script src="./js/Historico.js"></script>

<script>
    function logout() {
        localStorage.clear()
        window.location.replace('./Login.php')

    }
</script>