<?php include("./includes/menu.php") ?>
<?php include("./includes/head.php") ?>

<body>
    <div class="container centerHome">
        <img src="./imagens/Logo2.jpg" />

    </div>

</body>

</html>
<?php include("./includes/imports.php") ?>
<?php include("./includes/toast.php") ?>
<script src="./js/toast.js"></script>
<script>
    $('#preloader .inner').delay(1000).fadeOut();
    $('#preloader').delay(1000).fadeOut('slow');
    $('body').delay(1000).css({
        'overflow': 'visible'
    });
</script>