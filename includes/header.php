<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">
    <title>FoodHut | Free Bootstrap 4.3.x template</title>
   

    <!-- Bootstrap + FoodHut main styles -->
	<link rel="stylesheet" href="assets/css/foodhut.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
</head>


<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 30px">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#bodyHome">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services-area">Especialidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about-areaHome" >Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact-area" >Contato</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="home.php">
                <img src="./Painel/imagens/Logo.png" class="brand-img logoHome" alt="" style="margin-left:100px;">
                <span class="brand-txt" style="color: #ffff;">ABC Oftalmo</span>
            </a>
            <ul class="navbar-nav" style="margin-right: 150px;">
                <li class="nav-item">
                <a class="whatsapp-link" href="https://web.whatsapp.com/send?phone=11963388538" target="_blank">
		<i class="fa fa-whatsapp" style=" color:#2fb844; font-size: 50px;"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://web.whatsapp.com/send?phone=11963388538">(11) 96338-8538</a>
                </li>
            </ul>
        </div>
    </nav>




<script>
    function renderPage() {
        if (!window.location.pathname.includes('Home')) {
            window.location = './Home.php'
        }
    }

    function gotoLogin() {

        window.location = './Login.php'

    }
</script>


	<!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap affix -->
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- wow.js -->
    <script src="assets/vendors/wow/wow.js"></script>
    
    <!-- google maps -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap"></script>

    <!-- FoodHut js -->
    <script src="assets/js/foodhut.js"></script>

</body>