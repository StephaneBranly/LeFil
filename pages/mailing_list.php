<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php"); ?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            include_once("../lib/google_analytics.php");
            $nom_page='Mailing list';
            $description_page="";
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
	</head>
    <?php include_once("../components/components_include.php");?>
	<body>
    <?php
     _header(true);
        global $connnect;
        $mailing_list = SQLProtect(secure_get('mailing_list'),1);
        $action = secure_get('action');
        $user = SQLProtect(secure_get('user'),1);
        $code = SQLProtect(secure_get('code'),0);
        if($mailing_list!='news')
        {
            article("Oups... mauvaise page $mailing_list:)","Vous allez être redirigé vers l'accueil");
            echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
        }
        else
        {
            if($action=='subscribe')
            {
                $query = mysqli_query($connect,"SELECT mail_$mailing_list FROM `lf_users` WHERE `iduser`='$user'");
                $resp = mysqli_fetch_array($query);
                if($resp[0]==0)
                {
                    $query2 = mysqli_query($connect,"UPDATE `lf_users` 
                    SET `mail_$mailing_list` = FLOOR( 10000 + RAND( ) *89999 ) WHERE `iduser`='$user'");
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Vous êtes désormais abonné !";
                    article("Vous êtes désormais abonné à la mailing list !","Vous êtes désormais abonné à la mailing list !");
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
                }
                else
                {
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Vous êtes déjà abonné !";
                    article("Vous êtes déjà abonné à la mailing list !","Vous êtes déjà abonné à la mailing list !");
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
                }
            }
            else if($action=='unsubscribe')
            {
                $query = mysqli_query($connect,"SELECT mail_$mailing_list FROM `lf_users` WHERE `iduser`='$user'");
                $resp = mysqli_fetch_array($query);
                if($resp[0]==$code)
                {
                    $query2 = mysqli_query($connect,"UPDATE `lf_users` 
                    SET `mail_$mailing_list` = 0 WHERE `iduser`='$user'");
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Vous êtes désormais désabonné !";
                    article("Vous êtes désormais désabonné de la mailing list !","Vous êtes désormais désabonné de la mailing list !");
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
                }
                else if($resp[0]==0)
                {
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Vous êtes déjà désabonné !";
                    article("Vous êtes déjà désabonné à la mailing list !","Vous êtes déjà désabonné à la mailing list !");
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
                }
                else
                {
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Votre code de désabonnement est incorrect";
                    article("Votre code de désabonnement est incorrect","Votre code de désabonnement est incorrect");
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
                }
            }
        }
    
    _footer();
     ?>
    </body>
	
</html>