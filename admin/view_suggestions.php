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
            $description_page='';
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
        <h1>Suggestions :</h1>";
       
        $query = mysqli_query($connect,"SELECT * FROM `suggestions` ORDER BY `date` DESC");
        while($res = mysqli_fetch_array($query))
        {
            if($res['iduser']=="")
                $user="anonyme";
            else $user=$res['iduser'];
            $content=show_clean_string($res['content']);
            echo "<div class='suggestion'><h2>$res[title]</h2><p>$content</p><p>par $user le $res[date]</div>";

        }
        echo"<a href='../admin/home'>Retour</a>
        </section>";
    }
     else 
     container("Accès interdit","Il semblerait que vous n'avez pas le droit d'accèder à cette page... merci de retourner à l'accueil :)");
    _footer(); 
    ?>
    </body>
	
</html>