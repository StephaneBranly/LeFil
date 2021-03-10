<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php"); ?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // include_once("../lib/google_analytics.php");
            $user=secure_get('user');
            $nom_page=$user;
            $description_page="TODO";
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
	</head>
    <?php include_once("../components/components_include.php");?>
	<body id='root'>
    <?php
        $_SESSION['last_uri'] = $_SERVER['REQUEST_URI'];

        _header(true);
        $user=strtolower(SQLProtect($user,true));
        $query = mysqli_query($connect,"SELECT `iduser` FROM `lf_users` WHERE `iduser`='$user'");
        $res = mysqli_fetch_array($query);
        if ($res && count($res) != 0){
            profile($user);
            echo "<br/>";
            articles_profile($user);
        }
        else
        {
            container("Il semblerait que $user n'existe pas...","Vous allez être redirigé dans 5 secondes vers l'accueil");
            echo "<script type='text/javascript'>RedirectionJavascript('accueil',5000);</script>";
        }
        _footer();

        ?>
    </body>
	
</html>