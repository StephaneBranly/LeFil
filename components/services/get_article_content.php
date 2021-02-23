<?php
    include_once('../../lib/start_session.php');
    $id_article=SQLProtect(secure_get('id-article'),1);
    $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE lf_articles.identifiant=$id_article");
    $res = mysqli_fetch_array($query);
    if($res)
    {
        $content = $res['texte_contenu'];
        echo "$res[texte_contenu]";

    }
    else
        echo "<div>Article introuvable...</div>";
?>