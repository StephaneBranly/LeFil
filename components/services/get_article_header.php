<?php
    include_once('../../lib/start_session.php');
    $id_article=SQLProtect(secure_get('id-article'),1);
    $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE lf_articles.identifiant=$id_article");
    $res = mysqli_fetch_array($query);
    if($res)
    {
        echo "<div class='article_header'><h1>$res[titre]</h1>";
        if($res['sous_titre'])
            echo "<h2>$res[sous_titre]</h2>";

        echo "</div>";
    }
    else
        echo "<div>Article introuvable...</div>";
    
?>