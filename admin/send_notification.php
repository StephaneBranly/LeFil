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

        if(!empty($_POST))
        {
            $icon = SQLProtect(secure_post('icon'),1);
            $content = remove_balise(SQLProtect(secure_post('content'),1));
            $content="admin : ".$content;
            $iduser = SQLProtect(secure_post('iduser'),1);
            $date = date('Y-m-d H:i:s');
            if($iduser=="tout_le_monde")
            {
                $query = mysqli_query($connect,"SELECT * FROM `users` ORDER BY `iduser` ASC");
                while($res = mysqli_fetch_array($query))
                $query2 = mysqli_query($connect,"INSERT INTO `notifications` (iduser,icon,content,date) VALUES ('$res[iduser]','$icon','$content','$date')");
            }
            else
                $query = mysqli_query($connect,"INSERT INTO `notifications` (iduser,icon,content,date) VALUES ('$iduser','$icon','$content','$date')");
                echo "<script type='text/javascript'>write_notification('icon-paper-plane','Notification envoyée à $iduser','5000');</script>";
        }
        echo"<section id='admin'>
        <h1>Envoie de notification</h1>
        <form action='../admin/send_notification' method='post'>
            <select name='iduser'>
                <option value='tout_le_monde' selected>Tout le monde</option>";
                $query = mysqli_query($connect,"SELECT * FROM `users` ORDER BY `iduser` ASC");
                while($res = mysqli_fetch_array($query))
                    echo "<option value='$res[iduser]'>$res[iduser]</option>";
            echo"</select>
            <select name='icon'>";
            $list_icon=array("icon-chat","icon-mail","icon-user","icon-lightbulb","icon-cog","icon-gift","icon-ok-circled","icon-attention","icon-cafe");
            foreach($list_icon as $icon)
                echo "<option value='$icon'>$icon</option>";
            echo "</select>
            <input type='text' name='content' maxlenght='190'/>
            <button type='submit'>Envoyer notification<i class='icon-paper-plane'></i></button>
            <div>";
            foreach($list_icon as $icon)
                echo "$icon : <i class='$icon'></i><br/>";
            echo"</div>
        </form>
        <a href='../admin/home'>Retour</a>
        </section>";
    }
     else 
     container("Accès interdit","Il semblerait que vous n'avez pas le droit d'accèder à cette page... merci de retourner à l'accueil :)");
    _footer(); 
    ?>
    </body>
	
</html>