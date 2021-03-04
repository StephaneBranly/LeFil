<?php include_once("../lib/start_session.php");?>
<?php include_once("./admin.php");?>
<?php include_once("../lib/document_base.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            $nom_page='ADMIN';
            $description_page='description';
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php 
            $content = secure_get('content');
            $type_mail = secure_get('t');
            if($type_mail == 'news')
            {
                $message=generate_news_email($content);
                echo $message;
            }
            else if($type_mail == 'ads')
            {
                $message=generate_new_ads_email($connect);
                echo $message;
            }
        ?>
    </body>
</html>