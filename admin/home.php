<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php"); ?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link href="../admin/admin.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            $nom_page='ADMIN';
            $description_page='Surface admin';
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
	</head>
    <?php include_once("../components/components_include.php");?>
	<body>
    <?php
     _header(true);
    if(secure_session('is_admin'))
     {
        echo"<section id='admin'>
        <h1>Surface admin</h1>
        <a href='../admin/send_notification'>Envoyer une notification</a><br/>
        <a href='../admin/send_email'>Envoyer un mail</a><br/>
        <a href='../admin/new_ads_email'>Notifier des nouvelles annonces</a><br/>
        <a href='../admin/view_suggestions'>Voir les suggestions</a><br/>
        <a href='../admin/stats'>Voir les stats</a><br/>
        
        </section>";
     }
     else 
     container("Accès interdit","Il semblerait que vous n'avez pas le droit d'accèder à cette page... merci de retourner à l'accueil :)");
    _footer(); 
    ?>
    </body>
	
</html>