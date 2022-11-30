<?php include('./includes/head.php') ?>

<body style="color:#000;  background-color: #ffff;">
    <?php include('./includes/header.php') ?>
    
    <div class="imageTeste" >
        <img class="image-teste" />
    </div>
    <div class="p-4 title">
        <h1 id="titleHeader" style="color: #fff;"> </h1>
    </div>
    <div class="p-4">
        <h3 style="color: #0d2346;">SUA SAÚDE OCULAR EM 1° LUGAR</h3>
        <p>A Oftamologia é uma das áreas com mais avanços, e nós estamos focados em cada vez mais levar estes avanços até nossos pacientes.
            Doenças como hiperteção e diabetes vem comprometendo cada vez mais a qualidade visual, estamos investindo em equipamentos cada vez mais eficazes para tratamento.</p>

        <div id="explanation-area">
            <div style="display: flex;">
                <div style="flex: 1 1 0px; margin: 0px 8px 8px 8px">
                    <button class="btnOftalmo" id="surgeriesButton" onclick="optionsChooser('surgeriesButton','surgeries')">
                        Cirurgias
                    </button>
                </div>
                <div style="flex: 1 1 0px; margin: 0px 8px 8px 8px">
                    <button class="btnOftalmo" id="examButton" onclick="optionsChooser('examButton', 'exams')">
                        Exames
                    </button>
                </div>
                <div style="flex: 1 1 0px; margin: 0px 8px 8px 8px">
                    <button class="btnOftalmo" id="procedButton" onclick="optionsChooser('procedButton','procedimentos')">
                        Procedimentos
                    </button>
                </div>
            </div>
            <div class="explanationContainer">
                <div class="nav flex-column nav-pills" role="tablist" style="display: block;" id="optionsSource">
                </div>
                <div class="tab-content pl-3" id="contentSource">
                </div>
            </div>
        </div>
    </div>
    <?php include('./includes/footer.php') ?>
</body>

</html>
<?php include('./includes/imports.php') ?>
<script src="./mocks/index.js"></script>
<script src="./js/Oftalmologia.js"></script>