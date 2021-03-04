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
            if($res['image_couverture'] && $res['image_couverture']!='../img/lefil.png')
                echo "<img class='photo_couverture' src='$res[image_couverture]' alt='image de couverture' />";
            echo "<h1 class='title'>$res[titre]</h1>";
            if($res['sous_titre'])
                echo "<h1 class='subtitle'>$res[sous_titre]</h1>";
            if(!$res['anonymat_auteur'])
            {
                $query_auteur = mysqli_query($connect,"SELECT `username` FROM `lf_users` WHERE `iduser`='$res[auteur]'");
                $res_auteur = mysqli_fetch_array($query_auteur);
                if($res_auteur)
                    echo "<span class='authors'>Ecrit par $res_auteur[username]</span>";
                else
                    echo "<span class='authors'>Ecrit par $res[auteur]</span>";
            }
        }
        else
            echo "<div>Article introuvable...</div>";
    }
    else
        echo "<div>Accès en lecture refusé...</div>";
    
?>