<?php
function can_article_be_read($id_article)
{
    global $connect;
    $query = mysqli_query($connect,"SELECT statut,réservé_abonné FROM `lf_articles` WHERE `identifiant`=$id_article");
    $res = mysqli_fetch_array($query);
    if(($res && $res['statut']=='publié') && ($res['réservé_abonné']==0 || ($res['réservé_abonné']==1 && secure_session('connected')==true)))
        return 1;
    if($res && $res['statut']!='brouillon' && secure_session('is_admin'))
        return 1;
    if($res && ($res['statut']=='correction' || $res['statut']=='validation_admin' || $res['statut']=='refusé_admin') && secure_session('is_correcteur'))
        return 1;
    if($res && ($res['statut']=='validation_pvdc' || $res['statut']=='refusé_pvdc') && (secure_session('is_pvdc') || secure_session('is_correcteur')))
        return 1;
    if(secure_session('connected') && own_article($id_article))
        return 1;
    return 0;
}

function article_mini($id_article){
    global $connect;
    $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE `identifiant`=$id_article");
    $res = mysqli_fetch_array($query);
    if(can_article_be_read($id_article)){
        echo "<section class='miniarticle'><h1>$res[titre]</h1><h2>$res[sous_titre]</h2></section>";
    }
}

function read_article($id_article){
    global $connect;
    $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE `identifiant`=$id_article");
    $res = mysqli_fetch_array($query);
    if(can_article_be_read($id_article))
    {
        echo "<div id='container_display_article'>";
        echo "<div id='article_header'></div><div id='article_content'></div>";
        echo "</div>";

        echo "<script type='text/javascript'>window.addEventListener('load', function() {
            load_article($id_article);
        })</script>";
    }
   else{
       container('erreur','erreur');
   }
}
?>