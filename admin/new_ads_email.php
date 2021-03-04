<?php include_once("../lib/start_session.php");?>
<?php include_once("./admin.php");?>
<script type="text/javascript" src="./admin.js"></script>
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

        if(!empty($_POST))
        {
            $validation=SQLProtect(secure_post('validation'),1);
            if($validation)
            {
                $iduser = SQLProtect(secure_post('iduser'),1);

                $subject = "LeBonCup - Annonces recentes";

            $headers = "From: leboncup@assos.utc.fr \r\n";
            $headers .= "Reply-To: stephane.branly@etu.utc.fr \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
       
            $message=generate_new_ads_email($connect);
                
            if($iduser=="tout_le_monde")
                {
                    $query3 = mysqli_query($connect,"SELECT * FROM `users` ORDER BY `iduser` ASC");
                    while($res3 = mysqli_fetch_array($query3))
                        if($res3['mail']!='' && $res3['mail_ads'])
                        {
                            $message_copy=$message;
                            $message_copy=str_replace("[username]",$res3['username'], $message_copy);
                            $message_copy=str_replace("[iduser]",$res3['iduser'], $message_copy);
                            $message_copy=str_replace("[code]",$res3['mail_ads'], $message_copy);
                            mail($res3['mail'], $subject, $message_copy, $headers);
                        }
                    echo "<script type='text/javascript'>write_notification('icon-paper-plane','Mail envoyé à tout le monde','5000');</script>";  
                }
                else
                {
                    $query3 = mysqli_query($connect,"SELECT * FROM `users` WHERE `iduser`='$iduser'");
                    $res3 = mysqli_fetch_array($query3);
                    if($res3['mail']!='' && $res3['mail_ads'])
                    {
                        $message_copy=$message;
                        $message_copy=str_replace("[username]",$res3['username'], $message_copy);
                        $message_copy=str_replace("[iduser]",$res3['iduser'], $message_copy);
                        $message_copy=str_replace("[code]",$res3['mail_ads'], $message_copy);
                        mail($res3['mail'], $subject, $message_copy, $headers);
                        echo "<script type='text/javascript'>write_notification('icon-paper-plane','Mail envoyé à $res3[mail]','5000');</script>";
                    }
                    else 
                        echo "<script type='text/javascript'>write_notification('icon-exclamation','Mail non envoyé','5000');</script>";
                }
            }
            else
                echo "<script type='text/javascript'>write_notification('icon-exclamation','Il faut valider avant d envoyer un mail','5000');</script>";
        }
        echo"<section id='admin'>
        <h1>Envoie de mail</h1>
        <form action='../admin/new_ads_email' method='post'>
            <select name='iduser'>
                <option value='tout_le_monde' selected>Tout le monde</option>";
                $query = mysqli_query($connect,"SELECT * FROM `users` ORDER BY `iduser` ASC");
                while($res = mysqli_fetch_array($query))
                    echo "<option value='$res[iduser]'>$res[iduser] ($res[mail])</option>";
            echo"</select>
            Validation : <input required name='validation' type='checkbox'/>
            <button type='submit'>Envoyer mail<i class='icon-paper-plane'></i></button>
        </form>
        <button onclick='preview_email(\"ads\")'>Prévisualiser mail<i class='icon-eye'></i></button>
        <a href='../admin/home'>Retour</a>
        </section>";
    }
     else 
     container("Accès interdit","Il semblerait que vous n'avez pas le droit d'accèder à cette page... merci de retourner à l'accueil :)");
    _footer(); 
    ?>
    </body>
	
</html>
