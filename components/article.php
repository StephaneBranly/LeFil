<?php
function can_article_be_read($id_article)
{
    global $connect;
    // TODO TO DO revoir permissions lectures articles
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
?>