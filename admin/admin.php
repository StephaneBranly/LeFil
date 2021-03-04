<?php
function generate_news_email($content)
{
    include_once("../lib/start_session.php");
    return "<div style=\"margin: 0px;
    padding: 0px;
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    background-color: rgb(230, 230, 230);\" >
    <div style=\"background-color: rgb(250, 250, 250);
    width: 90%;
    display: inline-block;
    margin-bottom: 50px;
    margin-top: 50px;
    box-shadow: 5px 0px 10px rgb(221, 221, 221);
    border-radius: 5px;\">
    <h1 style=\"color: rgb(255, 98, 0);
    border-bottom: 1px solid rgb(221, 221, 221);
    width: 90%;
    padding-bottom: 5px;
    display: inline-block;\">LeBonCup</h1>
    <p>$content
    </p><br/><p>Merci de ne pas répondre à ce mail | <a href='https://assos.utc.fr/leboncup'>LeBonCup</a> | <a href='https://assos.utc.fr/leboncup/unsubscribe/[iduser]/news/[code]'>Se désabonner de la mailing list News</a></p></div></div>";
}

function generate_new_ads_email($connect)
{
    $annonces = "";
    $query2 = mysqli_query($connect,"SELECT * FROM `ads` INNER JOIN `users` WHERE users.iduser = ads.seller AND `visibility`='every_one' AND `status`='to_sell' ORDER BY `last_refresh` DESC LIMIT 10");
    while($res = mysqli_fetch_array($query2))
    {
        $nbr_images=0;
        if($res['image1'])
            $nbr_images++;
        if($res['image2'])
            $nbr_images++;
        if($res['image3'])
            $nbr_images++;
        if($nbr_images)
            $img=$res['image1'];
        else
            $img="nan_".$res['category'].".png";
        if($res['price'])
            $price=round($res['price'],2)."€";
        else
            $price="gratuit";
        $query4 = mysqli_query($connect, "SELECT COUNT(*) FROM `users_ad-views-likes` WHERE `idad`= $res[idad] AND `liked`=1");
        $res_likes = mysqli_fetch_array($query4);
        $likes=$res_likes[0];
        $title_cleaned=clean_string($res['title']);
        $description=clean_string($res['description']);
        $show_title=show_clean_string($res['title']);
        $show_descripton=show_clean_string($res['description']);
        $show_descripton=remove_balise($show_descripton);
        if(strlen($show_descripton)>97)
            $show_descripton=substr($show_descripton,0,97)."<b>...</b>";
        $annonce = "<a href='https://assos.utc.fr/leboncup/ad/$res[category]/$title_cleaned-$res[idad]' target='_blank'>
        <div class='simple_ad' >
        <table>
            <tr>
                <td class='left'>
                    <img src='https://assos.utc.fr/leboncup/ressources/images-ad/$img' alt='image annonce'/>
                    <span class='nb_photos'>$nbr_images photo.s</span>
                </td>
                <td class='center' >
                    <h1> <span class='price'>$price</span>$show_title</h1>
                    <p>$show_descripton</p>
                    <div class='details'>
                        <span class='seller'>postée par $res[username]</span>
                        <span class='date_post'>$res[last_refresh]</span>
                        <span class='views'>$res[views] vue.s</span>
                        <span class='likes'>$likes fav.s</span>
                    </div>
                </td>
            </tr>
        </table>
        </div></a>";
        $annonces .= $annonce;   
    }
    return "
    <style type=\"text/css\">
    @media all {
        .simple_ad {
          background-color: rgb(250, 250, 250);
          width: 90%;
          display: inline-block;
          margin: 0px;
          margin-bottom: 15px;
          box-shadow: 5px 0px 10px rgb(221, 221, 221);
          padding: 10px;
          border-radius: 5px;
        }
        .simple_ad:hover {
          cursor: pointer;
        }
        .simple_ad table,
        .simple_ad tbody,
        .simple_ad tr {
          width: 100%;
        }
        .simple_ad table .center,
        .simple_ad table .left {
          height: 100px;
        }
        .simple_ad table .left {
          width: 15%;
          text-align: right;
          vertical-align: bottom;
        }
        .simple_ad table .left img{
          width: 100%;
          height: 100px;
          object-fit: contain;
        }
        .simple_ad table .left .nb_photos {
          color: white;
          border-radius: 5px;
          padding: 4px;
          background-color: rgba(0, 0, 0, 0.5);
        }
        .simple_ad table .center {
          width: 85%;
          border-left: 1px solid rgb(221, 221, 221);
          color: rgb(0, 0, 0);
          overflow: hidden;
          text-overflow: ellipsis;
          padding-left: 3px;
        }
        .simple_ad .center h1 {
          color: rgb(255, 98, 0);
          border-bottom: 1px solid rgb(221, 221, 221);
          width: 90%;
          padding-bottom: 5px;
          display: inline-block;
          margin: 0px;
          text-align: left;
        }
        .simple_ad .center h1 .price {
          margin-right: 10px;
          padding-right: 10px;
          border-right: 1px solid rgb(221, 221, 221);
          color: rgb(35, 35, 189);
        }
        .simple_ad table .center .details {
          text-align: right;
          text-decoration: none;
        }
        .simple_ad table .center .details span {
          color: rgb(95, 95, 95);
          border-left: 1px solid rgb(136, 136, 136);
          margin-left: 5px;
          padding-left: 5px;
          font-size: 0.9em;
          text-decoration: none;
        }
        /*.simple_ad table .center .details .seller:hover {
        color: rgb(129, 129, 129);
        cursor: pointer;
      }*/
        .simple_ad table .center .details .liked {
          color: rgb(233, 21, 21);
          fill: rgb(233, 21, 21);
        }
        .simple_ad table .center .details .viewed {
          color: rgb(35, 35, 189);
        }
      }
      @media all and (max-device-width: 480px) {
        .simple_ad {
          width: 97%;
          padding: 0px;
          border: 0px solid rgba(0, 0, 0, 0);
        }
        .simple_ad table .center,
        .simple_ad table .left {
          height: 100px;
        }
        .simple_ad table .center {
          width: 60%;
          font-size: 30px;
          vertical-align: top;
          padding-top: 10px;
        }
        .simple_ad table .center .details {
          font-size: 15px;
        }
        .simple_ad table .center p,
        .simple_ad table .center .details .seller,
        .simple_ad table .center .details .date_post {
          display: none;
        }
        .simple_ad .center h1 .price {
          display: block;
          border-right: 0px solid rgba(221, 221, 221, 0);
        }
        .simple_ad .center h1 {
          border: 0px solid rgba(0, 0, 0, 0);
          font-size: 15px;
        }
        .simple_ad table .left {
          width: 37%;
        }
        .simple_ad table .left img{
          height: 200px;
        }
      }
    </style>
    <div style=\"margin: 0px;
    padding: 0px;
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    background-color: rgb(230, 230, 230);\" >
    <div style=\"background-color: rgb(250, 250, 250);
    width: 90%;
    display: inline-block;
    margin-bottom: 50px;
    margin-top: 50px;
    box-shadow: 5px 0px 10px rgb(221, 221, 221);
    border-radius: 5px;\">
    <h1 style=\"color: rgb(255, 98, 0);
    border-bottom: 1px solid rgb(221, 221, 221);
    width: 90%;
    padding-bottom: 5px;
    display: inline-block;\">LeBonCup</h1>
    <p>Bonjour [username] ! Voici les dernières annonces postées sur <a href='https://assos.utc.fr/leboncup'>LeBonCup</a> !</p>
    <p>Toi aussi, contribue et poste des annonces !</p>
    <a href='https://assos.utc.fr/leboncup/new_ad' style=\"
    color: rgb(255, 255, 255);
    display: inline-block;
    border: 1px solid rgba(201, 80, 5, 0);
    padding: 10px;
    text-decoration: none;
    border-radius: 5px;
    background-image: linear-gradient(
        45deg,
        rgb(255, 113, 25),
        rgb(255, 98, 0)
    );
    transition: all 0.1s;
    margin: 10px;\">Déposer une annonce</a>
    <br/>
    <div>
    $annonces
    </div>
    <br/>
    <a href='https://assos.utc.fr/leboncup/new_ad' style=\"
    color: rgb(255, 255, 255);
    display: inline-block;
    border: 1px solid rgba(201, 80, 5, 0);
    padding: 10px;
    text-decoration: none;
    border-radius: 5px;
    background-image: linear-gradient(
        45deg,
        rgb(255, 113, 25),
        rgb(255, 98, 0)
    );
    transition: all 0.1s;
    margin: 10px;\">Déposer une annonce</a>
    <p><br/><p>Merci de ne pas répondre à ce mail | <a href='https://assos.utc.fr/leboncup'>LeBonCup</a> | <a href='https://assos.utc.fr/leboncup/unsubscribe/[iduser]/ads/[code]'>Se désabonner de la mailing list Ads</a></p></div></div>";
    
}
?>