<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php");?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // TODO : TO DISCUSS ABOUT ANALYTICS include_once("../lib/google_analytics.php");
            $id_numero = secure_get('numero');
            $nom_page="Edition article $id_numero";
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
        if(secure_session('connected'))
        {
            if($id_numero==-1)
            {
                $user = secure_session('user');
                $query = mysqli_query($connect,"INSERT INTO `lf_articles`(`titre`, `sous_titre`,`anonymat_auteur`,`auteur`,`réservé_abonné`,`date_parution`,`texte_contenu`) VALUES ('titre','sous-titre',0,'$user',0,NOW(),'')");
                $id = mysqli_insert_id($connect);
               
                $_SESSION['notification_icon']='icon-pen';
                $_SESSION['notification_new']=true;
                $_SESSION['notification_content']="Un nouveau brouillon vient d'être créé !";
                container("Redirection en cours","Vous allez être redirigé sur le nouveau brouillon.");
                echo "<script type='text/javascript'>RedirectionJavascript('./edit-article-$id',100);</script>";
            }
            else
            {
                if(can_article_be_read($id_numero))
                    edit_article($id_numero);
                else
                    container("Article non éditable","Cet article n'existe pas, ou n'est pas visible.");
            }
        }
        else{
            container("Article non éditable","Vous devez être connecté pour accéder à cette interface.");
        }
        
     
    ?>
    </body>
	
</html>