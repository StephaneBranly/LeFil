<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php");?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // TODO : TO DISCUSS ABOUT ANALYTICS include_once("../lib/google_analytics.php");
            
            $nom_page="Les Spotted";
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
        new_spotted();
        all_spotted();
        arrow_up();    
        _footer();
    ?>
    </body>
</html>