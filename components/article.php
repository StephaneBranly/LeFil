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

function article_mini($id_article, $show_status = false, $edit_link = false){
    global $connect;
    $query = mysqli_query($connect,"SELECT * FROM `lf_articles` LEFT JOIN `lf_rubriques` ON lf_articles.id_rubrique = lf_rubriques.identifiant_rubrique WHERE `identifiant`=$id_article");
    $res = mysqli_fetch_array($query);

    if(can_article_be_read($id_article)){
        $edit = $edit_link ? "edit-" : "";
        $rubrique = $res['rubrique'] ? "<div class='rubrique'>$res[rubrique]</div>": "";
        echo "<a href='../".$edit."article-$id_article' class='link-miniarticle'><section class='miniarticle'>";
        echo "<div class='header-article'><h1>$res[titre]</h1></div>";
        echo "<div class='sub-section'>";
        if($show_status)
            echo "<div class='status_article $res[statut]'>$res[statut]</div>";
        echo "<h2>$res[sous_titre]</h2>";
        if($show_status)
            echo "<div class='right'>$rubrique<div class='last_update'>$res[date_parution]</div></div>";
        else
        echo "$rubrique";
        echo "</div></section></a>";
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