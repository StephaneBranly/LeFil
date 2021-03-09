<?php 
    include_once("../lib/start_session.php");

    $myUrl = "http://".$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?');
    $casUrl = "https://cas.utc.fr/cas/";
    require_once('../lib/xml.php');
    require_once('../lib/cas.php');

    if(isset($_GET['ticket']) || secure_get('section') == 'login')
    {
        $cas = new Cas($casUrl, $myUrl);

        $user = $cas->authenticate();
        if ($user == -1 || $user=="") {
            $cas->login();
        }
        else {
            $_SESSION['user'] = $user['user'];
            $_SESSION['prenom'] = $user['prenom'];
            $mail = $user['mail'];
        
            unset($_GET['ticket']);
            $url = strtok($myUrl, '?');

            $_SESSION['connected']=true;
            $user=$user['user'];

            $query = mysqli_query($connect,"SELECT `iduser`,`username` FROM `lf_users` WHERE `iduser`='$user'");
            $res = mysqli_fetch_array($query);
            $date = date('Y-m-d H:i:s');

            $query_admin = mysqli_query($connect,"SELECT `role` FROM `lf_roles` WHERE `login`='$user' AND `role`='admin'");
            $res_admin = mysqli_fetch_array($query_admin);
            $_SESSION['is_admin']=($res_admin && count($res_admin));

            $query_correcteur = mysqli_query($connect,"SELECT `role` FROM `lf_roles` WHERE `login`='$user' AND `role`='correcteur'");
            $res_correcteur = mysqli_fetch_array($query_correcteur);
            $_SESSION['is_correcteur']=($res_correcteur && count($res_correcteur));

            $query_redacteur = mysqli_query($connect,"SELECT `role` FROM `lf_roles` WHERE `login`='$user' AND `role`='redacteur'");
            $res_redacteur = mysqli_fetch_array($query_redacteur);
            $_SESSION['is_redacteur']=($res_redacteur && count($res_redacteur));

            $query_pvdc = mysqli_query($connect,"SELECT `role` FROM `lf_roles` WHERE `login`='$user' AND `role`='pvdc'");
            $res_pvdc = mysqli_fetch_array($query_pvdc);
            $_SESSION['is_pvdc']=($res_pvdc && count($res_pvdc));

            if(count($res) == 0)
            {
                $_SESSION['notification_icon']='icon-cup';
                $_SESSION['username']=$user;
                $_SESSION['notification_content']="Bienvenue $user ! Ton compte a été créé !";
                $query = mysqli_query($connect,"INSERT INTO `lf_users` (iduser,username,creation_account,last_connexion,mail,mail_news) VALUES ('$user','$user','$date','$date','$mail',FLOOR( 10000 + RAND( ) *89999 ))");
                echo "<script type='text/javascript'>RedirectionJavascript('profile/$user-edit',1000);</script>";
            }
            else
            {
                $_SESSION['username']=$res['username'];
                $_SESSION['notification_icon']='icon-cup';
                $_SESSION['notification_content']="Bonjour $res[username]";
                $query = mysqli_query($connect,"UPDATE `lf_users` SET `last_connexion` = '$date' WHERE iduser = '$user'");
                $last_page='../..'.secure_session('last_uri');
                if(secure_session('last_uri'))
                    echo "<script type='text/javascript'>setTimeout(\"{document.location.href='$last_page';};\", 1000);</script>";
                else
                    echo "<script type='text/javascript'>RedirectionJavascript('accueil',1000);</script>";
            }
        }
    }
    else if (secure_get('section')=='logout')
    {
        if(secure_session('connected'))
        {
            $cas = new Cas($casUrl, $myUrl);
            $cas->logout();
            $last_user=secure_session('user');
            $last_username=secure_session('username');
            $_SESSION['user'] = secure_get('user');
            $user=$_SESSION['user'];
            session_destroy();
            $_SESSION['connected']=false;
            $_SESSION['notification_icon']='icon-comment';
            $_SESSION['notification_content']="A bientôt $last_username"; 
        }              
        echo "<script type='text/javascript'>RedirectionJavascript('accueil',100);</script>";
    }
?>
<?php include_once("../lib/document_base.php"); ?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            include_once("../lib/google_analytics.php");
            $nom_page='Login user';
            $description_page="Page de connexion du site de LeBonCup";
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
	</head>
    <?php include_once("../components/components_include.php"); ?>
    <body>
        <?php
            _header(true);
            container('Redirection','Vous allez être redirigé...');
            $_SESSION['notification_new']=true;

        ?>
    </body>

</html>