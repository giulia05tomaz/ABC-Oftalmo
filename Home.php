<?php include('./includes/head.php') ?>


<style>

   

    .carousel-indicators ol li {
        background-color: blue;
        color: blue;
    }

    .carousel-indicators li .active {
        background-color: #1b3764 !important;
    }

    .d-block {
        margin: auto;
    }

    .title-pacientes {
        font-weight: 800;
        color: #696969;
    }

    body h1{
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
</style>

<body id="bodyHome">
    <!-- Carousel wrapper -->

    <?php include('./includes/header.php') ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-top: -110px;">
        <ol class="carousel-indicators" >
            <li data-target="#carouselExampleIndicators" data-slide-to="0" style="background-color:#1b3764;" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="6" style="background-color:#1b3764;"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="7" style="background-color:#1b3764;"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="./images/c1.jpg" style="height:680px;">
            </div>
            <div class="carousel-item ">
                <img class="d-block w-100" src="./images/c2.jpg" style="height:680px;">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./images/c3.jpg" style="height:680px;">
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="./images/c4.jpg" style="height:680px;">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./images/c5.jpg" style="height:680px;">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./images/c6.jpg" style="height:680px;">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./images/c7.jpg" style="height:680px;">
            </div>


        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
    <!-- Carousel wrapper -->

    <div id="services-area">
        <div class="main-title">
            <h1>Oftalmologia</h1>
        </div>
        <div class="cards-area">
            <div onclick="changeOftalmo('cirurgias')" class="p-5 card-style">
                <div class="card-title">
                    <i class="fas fa-syringe pr-2"></i>
                    <h4 class="mb-0">Cirurgias</h4>
                </div>

            </div>
            <div onclick="changeOftalmo('exames')" class="p-5 card-style">
                <div class="card-title">
                    <i class="far fa-eye pr-2"></i>
                    <h4 class="mb-0">Exames</h4>
                </div>

            </div>
            <div onclick="changeOftalmo('procedimentos')" class="p-5 card-style">
                <div class="card-title">
                    <i class="far fa-eye pr-2"></i>
                    <h4 class="mb-0">Procedimentos</h4>
                </div>

            </div>

        </div>
    </div>

    <div id="about-areaHome">
        <div class="main-title">
            <h1>SOBRE A ABC OFTALMO</h1>
        </div>
        <div class="main-about">
            <h3 class="about-title">ABC oftalmo tem como objetivo trazer cada vez mais qualidade de vida a você.</h3>
            <h5>Sua saúde ocular e bem estar são muito importantes para nós.</h5>
            <h5>Equipe treinada.</h5>
            <h5>Equipamentos modernos.</h5>
            <h5>Tudo para proporcionar a você confiança, tranquilidade e bem estar.</h5>
        </div>
    </div>

    <div class="section-videos">
        <h3>Vidas transformadas por meio da Clínica ABC Oftalmo</h3>
        <div class="videos">
            <div>
                <video width="400" controls id="video1">
                    <source src="./Videos/1.mp4" type="video/mp4">

                </video>
                <h5 class="title-pacientes">CELSO ALVES DE LIMA</h5>
                <h5 class="title-pacientes">Paciente de facectomia (catarata)</h5>
            </div>
            <div>
                <video width="400" controls id="video5">
                    <source src="./Videos/5.mp4" type="video/mp4">

                </video>
                <h5 class="title-pacientes">LUCIANA AUGOSTINHO DE ARAÚJO</h5>
                <h5 class="title-pacientes">Consulta, exames e acompanhamento</h5>
            </div>
        </div>
        <div class="videos">
            <div>
                <video width="400" controls id="video3">
                    <source src="./Videos/3.mp4" type="video/mp4">
                </video>
                <h5 class="title-pacientes">JOSINALDO JOSÉ FERES</h5>
                <h5 class="title-pacientes">Paciente cirurgia Pterígio</h5>
            </div>
            <div>
                <video width="400" controls id="video4">
                    <source src="./Videos/4.mp4" type="video/mp4">

                </video>
                <h5 class="title-pacientes">ROSANA BEZERRA</h5>
                <h5 class="title-pacientes">Exame uso lente de contato</h5>
            </div>
        </div>


        <div class="agenda-titles mt-5">
            <h4 class="text-center">Você não precisa mais enfrentar atrasos e mau atendimento em planos de saúde, protocolos mal elaborados e hospitais públicos.</h4>
            <h5 class="text-center">Agende agora sua consulta com um Médico Oftalmologista.</h5>
        </div>
        <div id="contact-area" style="background-color: #fff;" class="mt-3 mb-5 agendamento">

            <div class="container">
                <div class="row">

                    <div class="col-md-3"></div>
                    <div class="col-md-6" id="contact-form">
                        <form action="">
                            <div class="row mt-3">
                                <div class="col-md-6" id="contact-form">
                                    <label for="nameAgendamento" class="float-left text-dark">Nome</label>
                                    <input type="text" class="form-control" maxlength="30" placeholder="Nome" id="nameAgendamento" name="email">
                                </div>
                                <div class="col-md-6" id="contact-form">
                                    <label for="nomeConvenio" class="float-left text-dark">Telefone</label>
                                    <input type="text" class="form-control" maxlength="15" placeholder="Telefone" id="telAgenda" name="telefone">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="nomeConvenio" class="float-left text-dark">Email</label>
                                <input type="text" class="form-control" maxlength="40" placeholder="Email" id="emailAgenda" name="subject">
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6" id="contact-form">
                                    <label for="nomeConvenio" class="float-left text-dark">Data</label>
                                    <input type="date" class="form-control" placeholder="Nome" id="dataAgenda" name="email">
                                    <small id="dateHelper" class="text-danger"></small>
                                </div>
                                <div class="col-md-6" id="contact-form">
                                    <label for="nomeConvenio" class="float-left text-dark">Hora</label>
                                    <select class="custom-select selectAgd" name="Eventos2Modal" id="timer" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3 ml-1">
                                <input class="checkboxList float-left mt-1" type="checkbox" id="pedidoExams" />
                                <span class="text-dark float-left pl-2 pb-2">
                                    Tenho pedido de exames
                                </span>
                            </div>
                            <div class="mt-3">
                                <label for="cmbStatus " class="text-dark float-left">Procedimentos</label>
                                <select disabled data-count-selected-text=" {0} itens selecionados" id="cmbStatus" class="selectpicker  form-control text-dark" title="Nenhum selecionado" multiple data-selected-text-format="count > 1" data-live-search="true">

                                </select>

                            </div>
                            <div class="mt-3">
                                <textarea class="form-control" rows="3" placeholder="Deixe uma mensagem" id="message" name="message"></textarea>

                            </div>
                            <div class="mt-3">
                                <label class="text-dark text-left">Estou ciente que este formulário não garante a data e horário escolhida e que esta é apenas uma
                                    preferência de horário (aguardar confirmação via whatsapp).</label>
                                <input value="DINHEIRO" class="checkboxList float-left mt-1" type="checkbox" id="confirmAgenda" /><span class="text-dark float-left pl-2 pb-2">Eu concordo</span>
                            </div>
                            <div class="mt-3">

                                <button type="button" class="btn btn-darkblue" style="cursor: pointer;" id="psePaciente" onclick="gravaAgendamento()">Enviar</button>
                                <div class="row justify-content-center">
                                    <small id="psePacienteHelper" class="text-danger"></small>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade" id="modalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <img style="    object-fit: contain; width: 100%;" src="./images/modalImage1.jpeg" alt="modalImage" />
                    </div>

                </div>
            </div>
        </div> -->

        <?php include('./includes/footer.php') ?>
</body>

</html>

<?php include('./includes/imports.php') ?>
<?php include("./Painel/includes/messageModal.php") ?>
<script src="./js/Home.js"></script>
<script>
    function changeOftalmo(type) {
        localStorage.setItem('page', type)
        window.location = './Oftalmologia.php'
    }

    function scroolToAgenda() {


        $([document.documentElement, document.body]).animate({
                scrollTop: $('.agendamento').offset().top - 100,
            },
            1000
        );
    }
</script>