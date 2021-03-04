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

        echo"<section id='admin'>
        <h1>Stats :</h1>";
    $query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users` WHERE 1=1");
     $res_count = mysqli_fetch_array($query);
     $nbr_users=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `ads` WHERE 1=1");
     $res_count = mysqli_fetch_array($query);
     $nbr_qds=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `ads` WHERE ads.status = 'to_sell'");
     $res_count = mysqli_fetch_array($query);
     $nbr_ads_to_sell=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `ads` WHERE ads.status = 'sold'");
     $res_count = mysqli_fetch_array($query);
     $nbr_ads_sold=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users_ad-views-likes` WHERE `liked`=1");
     $res_count = mysqli_fetch_array($query);
     $nbr_ads_likes=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT SUM(`views`) FROM `ads` WHERE 1=1");
     $res_count = mysqli_fetch_array($query);
     $nbr_ads_views=$res_count[0];

     $query = mysqli_query($connect, 
     "SELECT SUM(`price`) FROM `ads` WHERE ads.status = 'sold'");
     $res_count = mysqli_fetch_array($query);
     $sum_sold=$res_count[0];

    /*$query = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `messages` WHERE 1=1");
     $res_count = mysqli_fetch_array($query);*/
    //$nbr_messages=$res_count[0];

    $query_users_day = mysqli_query($connect, 
    "SELECT COUNT(*) FROM `users` WHERE `last_connexion` >= DATE_SUB(NOW(), INTERVAL 1 DAY)
    ");
    $res_count_query_users_day = mysqli_fetch_array($query_users_day);
    $nbr_users_query_users_day=$res_count_query_users_day[0];

    $query_users_week = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users` WHERE `last_connexion` >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
     ");
     $res_count_query_users_week = mysqli_fetch_array($query_users_week);
     $nbr_users_query_users_week=$res_count_query_users_week[0];

     $query_users_month = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users` WHERE `last_connexion` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) 
     ");
     $res_count_query_users_month = mysqli_fetch_array($query_users_month);
     $nbr_users_query_users_month=$res_count_query_users_month[0];



     $query_new_day = mysqli_query($connect, 
    "SELECT COUNT(*) FROM `users` WHERE `creation_account` >= DATE_SUB(NOW(), INTERVAL 1 DAY)
    ");
    $res_count_query_new_day = mysqli_fetch_array($query_new_day);
    $nbr_users_query_new_day=$res_count_query_new_day[0];

    $query_new_week = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users` WHERE `creation_account` >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
     ");
     $res_count_query_new_week = mysqli_fetch_array($query_new_week);
     $nbr_users_query_new_week=$res_count_query_new_week[0];

     $query_new_month = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `users` WHERE `creation_account` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) 
     ");
     $res_count_query_new_month = mysqli_fetch_array($query_new_month);
     $nbr_users_query_new_month=$res_count_query_new_month[0];




     $query_ads_day = mysqli_query($connect, 
     "SELECT COUNT(*) FROM `ads` WHERE `publish_date` >= DATE_SUB(NOW(), INTERVAL 1 DAY)
     ");
     $res_count_query_ads_day = mysqli_fetch_array($query_ads_day);
     $nbr_ads_query_ads_day=$res_count_query_ads_day[0];
 
     $query_ads_week = mysqli_query($connect, 
      "SELECT COUNT(*) FROM `ads` WHERE `publish_date` >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
      ");
      $res_count_query_ads_week = mysqli_fetch_array($query_ads_week);
      $nbr_ads_query_ads_week=$res_count_query_ads_week[0];
 
      $query_ads_month = mysqli_query($connect, 
      "SELECT COUNT(*) FROM `ads` WHERE `publish_date` >= DATE_SUB(NOW(), INTERVAL 1 MONTH) 
      ");
      $res_count_query_ads_month = mysqli_fetch_array($query_ads_month);
      $nbr_ads_query_ads_month=$res_count_query_ads_month[0];



      $query_ads_sold_day = mysqli_query($connect, 
      "SELECT COUNT(*) FROM `ads` WHERE `last_refresh` >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND `status`='sold'
      ");
      $res_count_query_ads_sold_day = mysqli_fetch_array($query_ads_sold_day);
      $nbr_ads_query_ads_sold_day=$res_count_query_ads_sold_day[0];
  
      $query_ads_sold_week = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `ads` WHERE `last_refresh` >= DATE_SUB(NOW(), INTERVAL 7 DAY)  AND `status`='sold'
       ");
       $res_count_query_ads_sold_week = mysqli_fetch_array($query_ads_sold_week);
       $nbr_ads_query_ads_sold_week=$res_count_query_ads_sold_week[0];
  
       $query_ads_sold_month = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `ads` WHERE `last_refresh` >= DATE_SUB(NOW(), INTERVAL 1 MONTH)  AND `status`='sold'
       ");
       $res_count_query_ads_sold_month = mysqli_fetch_array($query_ads_sold_month);
       $nbr_ads_query_ads_sold_month=$res_count_query_ads_sold_month[0];

     
       $query_mailinglist_news_sub = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `users` WHERE mail_news <> 0");
       $res_count_query_mailinglist_news_sub = mysqli_fetch_array($query_mailinglist_news_sub);
       $nbr_mailinglist_news_sub=$res_count_query_mailinglist_news_sub[0];

       $query_mailinglist_news_un = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `users` WHERE mail_news = 0");
       $res_count_query_mailinglist_news_un = mysqli_fetch_array($query_mailinglist_news_un);
       $nbr_mailinglist_news_un=$res_count_query_mailinglist_news_un[0];

       $query_mailinglist_ads_sub = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `users` WHERE mail_ads <> 0");
       $res_count_query_mailinglist_ads_sub = mysqli_fetch_array($query_mailinglist_ads_sub);
       $nbr_mailinglist_ads_sub=$res_count_query_mailinglist_ads_sub[0];

       $query_mailinglist_ads_un = mysqli_query($connect, 
       "SELECT COUNT(*) FROM `users` WHERE mail_ads = 0");
       $res_count_query_mailinglist_ads_un = mysqli_fetch_array($query_mailinglist_ads_un);
       $nbr_mailinglist_ads_un=$res_count_query_mailinglist_ads_un[0];

    $description = "<table>
    <tr><th class='name'>Proprieté</th><th>Moins d'1 jour</th><th>Moins d'1 semaine</th><th>Moins d'1 mois</th><th class='total'>TOTAL</th></tr>
    <tr><td class='name'>Comptes créés</td><td>$nbr_users_query_new_day</td><td>$nbr_users_query_new_week</td><td>$nbr_users_query_new_month</td><td class='total'>$nbr_users</td></tr>
    <tr><td class='name'>Comptes connectés</td><td>$nbr_users_query_users_day</td><td>$nbr_users_query_users_week</td><td>$nbr_users_query_users_month</td><td class='total'>--</td></tr>
    <tr><td class='name'>Annonces créées</td><td>$nbr_ads_query_ads_day</td><td>$nbr_ads_query_ads_week</td><td>$nbr_ads_query_ads_month</td><td class='total'>$nbr_qds</td></tr>
    <tr><td class='name'>Annonces conclues</td><td>$nbr_ads_query_ads_sold_day</td><td>$nbr_ads_query_ads_sold_week</td><td>$nbr_ads_query_ads_sold_month</td><td class='total'>$nbr_ads_sold</td></tr>  
    </table>
    
    <br/>
    <b>$nbr_ads_to_sell</b> annonces disponibles !<br/>
     <b>$nbr_ads_views</b> annonces vues !<br/>
     <b>$nbr_ads_likes</b> annonces en favories !<br/>
     <b>$sum_sold €</b> dépensés !<br/><br/>
     <b>$nbr_mailinglist_news_sub</b> abonnés à la mailist news ! ($nbr_mailinglist_news_un non abonnés)<br/>
     <b>$nbr_mailinglist_ads_sub</b> abonnés à la mailist ads ! ($nbr_mailinglist_ads_un non abonnés)<br/>";

   
     echo "<p>$description</p>";
        echo"<a href='../admin/home'>Retour</a>
        </section>";
    }
     else 
     container("Accès interdit","Il semblerait que vous n'avez pas le droit d'accèder à cette page... merci de retourner à l'accueil :)");
    _footer(); 
    ?>
    </body>
	
</html>