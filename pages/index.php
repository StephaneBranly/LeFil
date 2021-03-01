<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php");?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // TODO : TO DISCUSS ABOUT ANALYTICS include_once("../lib/google_analytics.php");
            $nom_page='Accueil';
            // TODO : ADD DESCRIPTION HERE
            $description_page="TODO";
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
        <meta property='og:image'  content='https://assos.utc.fr/lefil/ressources/images/logo.png'/>
	</head>
    <?php include_once("../components/components_include.php");?>
	<body id='root'>
    <?php
        $_SESSION['last_uri'] = $_SERVER['REQUEST_URI'];        
        _header();
        container("Site en construction...","Le site est actuellement en construction, des mises à jours sont faites régulièrement afin de rendre les différentes sections rapidement disponibles. <br/>Désolé de la gène occasionnée.");
        numeros(4);
        see_all_numeros_button();

    ?>
    </body>
	
</html>