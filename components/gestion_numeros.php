<?php 
    function load_numero_admin($journal){
        echo "<option value='$journal[numéro]'>Le Fil $journal[numéro] ($journal[statut])</option>";
    }
    function numero_admin($id){
        global $connect;
        $query_journal = mysqli_query($connect,"SELECT * FROM `lf_journaux` WHERE numéro = $id");
        $journal =  mysqli_fetch_array($query_journal);
        echo "<div class='numero_admin $journal[statut]'><h1>$journal[numéro]</h1>";

        if(isset($_POST['publier']) && $journal['statut'] == 'en_attente')
        {
            $current_login = secure_session('user');
            $query_upd_num = mysqli_query($connect,"UPDATE `lf_journaux` SET `statut` = 'publié', `date_publication` = NOW() WHERE `numéro`= $id");
            $query_articles = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE numero_journal = $id");
            while($res = mysqli_fetch_array($query_articles))
            {
                $id_art = $res['identifiant'];
                if($res['statut']=='attente_publication'){
                    $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'publié', `date_parution` = NOW() WHERE `identifiant`= $id_art");
                    $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id_art,'$current_login',NOW(),\"L'article a été publié\",'8ff05f','icon-note')");
                    $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res[auteur]','Article $res[identifiant] publié sur le nouveau numéro $id','icon-lightbulb',0)");   
                }else{
                    $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `numero_journal` = '0' WHERE `identifiant`= $id_art");
                    $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id_art,'$current_login',NOW(),\"L'article n'a pas pu être publié sur le Fil numéro $id\",'f97528','icon-note')");
                    $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res[auteur]','Article $res[identifiant] NON publié sur le nouveau numéro $id','icon-lightbulb',0)");   
                }
            }
        }
        if($journal['statut']=='publié')
        {
            echo "<span class='date'>sorti le $journal[date_publication]</span>";

            echo "<br/>Contient les articles :";
            echo "<ul>";
            $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE numero_journal = $journal[numéro] AND statut='publié'");
            while($res = mysqli_fetch_array($query))
                echo "<li><a href='../article-$res[identifiant]'>[$res[identifiant]] - $res[titre]</a></li>";
            echo "</ul>";
        }
        else
        {

            echo "Date de sortie prévue : <input name='date_publication' value='$journal[date_publication]'/>";
            echo "<br/>Articles prévus pour ce numéro :";
            echo "<div class='list_numeros'>";
            $query = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE numero_journal = $journal[numéro]");
            while($res = mysqli_fetch_array($query))
            {
                if($res['statut']=='attente_publication')
                    $icon = "<i class='icon icon-ok-circled'></i>";
                else
                    $icon = "<i class='icon icon-exclamation'></i>";
                echo "<div class='a_numero'><a href='../edit-article-$res[identifiant]'>$icon [$res[identifiant]] - $res[titre] ($res[statut])</a></div>";
            }
            echo "</div>";
            echo "<button type='submit'>Mettre a jour les informations</button>";
            echo "<form method='post' action=''><p>Seuls les articles avec le statut 'attente_publication' (<i class='icon icon-ok-circled'></i>) seront publiés sur le numéro. Les autres articles (<i class='icon icon-exclamation'></i>) devront se rattacher à un prochain numéro.</p>Validation : <input required name='validation' type='checkbox'/>
            <button type='submit' name='publier'>Publier le journal</button></form>";
        }
        echo "</div>";
    }

    function gestion_numero()
    {
        global $connect;

        if(isset($_POST['new_numero']))
        {
            $query_last_numero = mysqli_query($connect,"SELECT MAX(`numéro`) FROM `lf_journaux`");
            $res_last_numero = mysqli_fetch_array($query_last_numero);
            $next_numero = $res_last_numero[0] + 1;
            $query = mysqli_query($connect,"INSERT INTO `lf_journaux` (`numéro`, `lien_pdf`, `date_sortie`, `statut`, `date_publication`) VALUES ('$next_numero', NULL, '0', 'en_attente', NOW());"); 
        }
        $query = mysqli_query($connect,"SELECT * FROM `lf_journaux` ORDER BY numéro DESC");
        
        echo"<section id='gestion_numeros'>
        <form action='' method='get'><button type='submit' name='new_numero'>Créer un nouveau numéro</button>
        <br/><select name='num'>";
        while($res = mysqli_fetch_array($query))
            load_numero_admin($res);
        echo "</select><button type='submit'>Charger le numéro</button>
        </form>";
        
        if(isset($_GET['num']))
        {
            $id_num = secure_get('num');
            numero_admin($id_num);
        }
        echo "</section>";
    }
?>