<?php
    include_once('../../lib/start_session.php');
    include_once('../article.php');
    $id_article=SQLProtect(secure_get('id-article'),1);
    if(can_article_be_read($id_article))
    {
        $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE lf_articles.identifiant=$id_article");
        $res = mysqli_fetch_array($query);
        if($res)
        {
            $content = $res['texte_contenu'];
            echo "$res[texte_contenu]";
        }
        else
            echo "<div>Article introuvable...</div>";
    }
    else
        echo "<div>Accès en lecture refusé...</div>";
?>