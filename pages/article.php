<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php");?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // TODO : TO DISCUSS ABOUT ANALYTICS include_once("../lib/google_analytics.php");
            $id_article = secure_get('id');
            if(!$id_article)
                $id_article = secure_get('paper');
            $query = mysqli_query($connect,"SELECT `titre` FROM `lf_articles` WHERE `identifiant`=$id_article");
            $res = mysqli_fetch_array($query);
            if($res)
                $nom_page="Article $res[titre]";
            else 
                $nom_page="Article $id_article";
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
        if(can_article_be_read($id_article))
            read_article($id_article);
        else
            container("Article non visible","Cet article n'existe pas, ou n'est pas visible.");
        arrow_up();    
        _footer();
    ?>
    </body>
	
</html>