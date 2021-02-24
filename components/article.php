<?php
function can_article_be_read($id_article)
{
    global $connect;
    // TODO TO DO revoir permissions lectures articles
    $query = mysqli_query($connect,"SELECT statut,réservé_abonné FROM `lf_articles` WHERE `identifiant`=$id_article");
    $res = mysqli_fetch_array($query);
    if(($res && $res['statut']=='publié') && ($res['réservé_abonné']==0 || ($res['réservé_abonné']==1 && secure_session('connected')==true)))
        return 1;
    if($res['statut']!='brouillon' && is_admin())
        return 1;
    return 0;
}
?>