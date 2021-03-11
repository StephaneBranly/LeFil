<?php
    function can_article_be_edited($id_article)
    {
        global $connect;
        $query = mysqli_query($connect,"SELECT statut FROM `lf_articles` WHERE `identifiant`=$id_article");
        $res = mysqli_fetch_array($query);
        if(!secure_session('connected'))
            return 0;
        
        if($res['statut']!='publié' && own_article($id_article))
            return 1;
        if($res['statut']!='brouillon' && secure_session('is_admin'))
            return 1;
        return 0;
    }

    function own_article($id_article){
        global $connect;
        $current_user = secure_session('user');
        $query_author = mysqli_query($connect,"SELECT auteur FROM `lf_articles` WHERE `identifiant`=$id_article AND `auteur`='$current_user'");
        $res_author = mysqli_fetch_array($query_author);
        return ($res_author && count($res_author));
    }

    function edit_article($id)
    {
        global $connect;
        $buttons_update_status = array('','','','','');

        $query_article = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE identifiant=$id");
        $res_article = mysqli_fetch_array($query_article);

        $status = $res_article['statut'];
        $current_login = secure_session('user');
        if(isset($_POST['send_comment'])){
            $message = SQLProtect(secure_post('message'),1);
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),'$message','cecece','icon-comment')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','L'article $res_article[identifiant] a reçu un commentaire','icon-comment',0)");
        }
        if($status=='brouillon' && isset($_POST['brouillon']) && own_article($id)){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'correction' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),'Article soumis à correction','8ff05f','icon-search')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] soumis à correction','icon-lightbulb',0)");
        }else if($status=='correction' && isset($_POST['corrige']) && (secure_session('is_admin') || own_article($id))){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'validation_admin' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article corrigé, soumis a la validation d'un admin\",'8ff05f','icon-hammer')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] corrigé','icon-lightbulb',0)");
        }else if(($status=='validation_admin' || $status=='refusé_admin') && isset($_POST['valider_admin']) && secure_session('is_admin')){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'validation_pvdc' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article validé par l'admin, soumis a la validation du PVDC\",'8ff05f','icon-hammer')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] validé par admin','icon-lightbulb',0)");
        }else if($status=='validation_admin' && isset($_POST['refuser_admin']) && secure_session('is_admin')){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'refusé_admin' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article refusé par l'admin\",'f44a4a','icon-hammer')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] refusé par admin','icon-lightbulb',0)");
        }else if(($status=='validation_pvdc' || $status=='refusé_pvdc') && isset($_POST['valider_pvdc']) && (secure_session('is_admin') || secure_session('is_pvdc'))){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'attente_publication' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article validé par le PVDC, en attente de publication\",'8ff05f','icon-hammer')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] validé par le PVDC','icon-lightbulb',0)");
        }else if($status=='validation_pvdc' && isset($_POST['refuser_pvdc']) && (secure_session('is_admin') || secure_session('is_pvdc'))){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'refusé_pvdc' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article refusé par le PVDC\",'f44a4a','icon-note')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] refusé par le PVDC','icon-lightbulb',0)");
        }else if($status=='attente_publication' && isset($_POST['publier']) && secure_session('is_admin') && !$res_article['numero_journal']){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'publié', `date_parution` = NOW() WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"L'article a été publié\",'8ff05f','icon-note')");
            $query_notif = mysqli_query($connect,"INSERT INTO `lf_notifications`(`date`, `iduser`, `content`,`icon`,`viewed`) VALUES (NOW(),'$res_article[auteur]','Article $res_article[identifiant] publié','icon-lightbulb',0)");
        }

        if(isset($_POST['update_button']) && can_article_be_edited($id)){
            $modifications = "";
            $titre = SQLProtect(secure_post('titre'),1);
            if($titre != $res_article['titre']) $modifications .= "titre ; ";
            $soustitre = SQLProtect(secure_post('soustitre'),1);
            if($soustitre != $res_article['sous_titre']) $modifications .= "sous-titre ; ";
            $contenu = SQLProtect(secure_post('contenu'),1);
            if($contenu != $res_article['contenu']) $modifications .= "contenu ; ";
            $description_courte = SQLProtect(secure_post('courte_description'),1);
            if($description_courte != $res_article['courte_description']) $modifications .= "courte description ; ";
            $genre = SQLProtect(secure_post('genre'),1);
            $registre = SQLProtect(secure_post('registre'),1);
            $rubrique = SQLProtect(secure_post('rubrique'),0);
            $image_couverture = SQLProtect(secure_post('image_couverture'),1);
            if($image_couverture != $res_article['image_couverture']) $modifications .= "image de couverture ; ";

            $anonymat_auteur = SQLProtect(secure_post('anonymat_auteur'),0);
            if($anonymat_auteur != $res_article['anonymat_auteur']) $modifications .= "anonymat auteur ; ";
            $reserve_abonne = SQLProtect(secure_post('reserve_abonne'),0);
            if($reserve_abonne != $res_article['réservé_abonné']) $modifications .= "réservé abonné ; ";
            $article_pour = SQLProtect(secure_post('article_pour'),1);
            $concours = "";
            $numero_fil = 0;
            if(preg_match("/[a-z][0-9]+/i", $article_pour))
            {
                $concours = $article_pour;
            }else if((secure_session('is_redacteur') || secure_session('is_admin')) && $article_pour != 'horsserie'){
                $numero_fil = $article_pour;
            }
            if($concours != $res_article['id_concours']) $modifications .= "ID concours ; ";
            if($numero_fil != $res_article['numero_journal']){
                if($status=='publié')
                    $numero_fil = $res_article['numero_journal'];
                else
                    $modifications .= "numéro fil ; ";
            }
            if($genre=='---') $genre = '';
            if($rubrique=='---') $rubrique = 0;
            if($registre=='---') $registre = '';

            if($genre != $res_article['id_genre']) $modifications .= "genre ; ";
            if($registre != $res_article['id_registre']) $modifications .= "registre ; ";
            if($rubrique != $res_article['id_rubrique']) $modifications .= "rubrique ; ";

            $query_upd_content = mysqli_query($connect,"UPDATE `lf_articles` SET `titre` = \"$titre\", `sous_titre` = \"$soustitre\", 
            `courte_description` = \"$description_courte\", `texte_contenu` = \"$contenu\",
             `image_couverture` = \"$image_couverture\", `id_rubrique` = $rubrique, 
             `id_registre` = \"$registre\", `id_genre` = \"$genre\", `id_concours` = \"$concours\", `numero_journal` = $numero_fil, 
             `réservé_abonné` = $reserve_abonne, `anonymat_auteur` = $anonymat_auteur, `date_parution` = NOW() WHERE `lf_articles`.`identifiant` = $id"); 
            if($modifications)
                $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Des modifications ont été faites : $modifications\",'f9e728','icon-pen')");
        }
        $query_article = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE identifiant=$id");
        $res_article = mysqli_fetch_array($query_article);

        $status = $res_article['statut'];

        $liste_genre = ($res_article['id_genre']=="") ? "<option name='-' value='' selected>---</option>" : "<option name='-'>---</option>";
        $query0 = mysqli_query($connect,"SELECT genre FROM `lf_genre` WHERE etat=1");
        while($res = mysqli_fetch_array($query0))
            $liste_genre .= ($res_article['id_genre']==$res['genre']) ? "<option name='$res[genre]' value='$res[genre]' selected>$res[genre]</option>" : "<option name='$res[genre]' value='$res[genre]'>$res[genre]</option>";
        
        $liste_rubriques = ($res_article['id_rubrique']=="") ? "<option name='-' value='' selected>---</option>" : "<option name='-'>---</option>" ;
        $query1 = mysqli_query($connect,"SELECT rubrique, identifiant_rubrique FROM `lf_rubriques` WHERE etat=1");
        while($res = mysqli_fetch_array($query1))
            $liste_rubriques .= ($res_article['id_rubrique']==$res['identifiant_rubrique']) ? "<option name='$res[rubrique]' value='$res[identifiant_rubrique]' selected>$res[rubrique]</option>" : "<option name='$res[rubrique]' value='$res[identifiant_rubrique]'>$res[rubrique]</option>";   

        $liste_registres = ($res_article['id_registre']=="") ? "<option name='-' value='' selected>---</option>" : "<option name='-'>---</option>" ;
        $query2 = mysqli_query($connect,"SELECT registre FROM `lf_registres` WHERE etat=1");
        while($res = mysqli_fetch_array($query2))
            $liste_registres .= ($res_article['id_registre']==$res['registre']) ? "<option name='$res[registre]' value='$res[registre]' selected>$res[registre]</option>" : "<option name='$res[registre]' value='$res[registre]'>$res[registre]</option>";

        $article_pour = (!$res_article['id_concours']=="" && !$res_article['numero_journal']) ? "<option name='horsserie' value='horsserie' selected>Hors-série</option>" : "<option name='horsserie' value='horsserie'>Hors-série</option>" ;
        if(secure_session('is_redacteur') || secure_session('is_admin'))
        {
            if($res_article['statut']=='publié')
                $query3 = mysqli_query($connect,"SELECT numéro, date_publication FROM `lf_journaux`");
            else
                $query3 = mysqli_query($connect,"SELECT numéro, date_publication FROM `lf_journaux` WHERE statut='en_attente'");
            while($res = mysqli_fetch_array($query3))
                $article_pour .= ($res_article['numero_journal']==$res['numéro']) ?  "<option name='$res[numéro]' value='$res[numéro]' selected>Le Fil $res[numéro] (publication prévue le $res[date_publication])</option>" : 
                "<option name='$res[numéro]' value='$res[numéro]'>Le Fil $res[numéro] (publication prévue le $res[date_publication])</option>";
                $query3 = mysqli_query($connect,"SELECT numéro, date_sortie FROM `lf_journaux` WHERE statut='brouillon'");
        }

        $query4 = mysqli_query($connect,"SELECT semestre_édition FROM `lf_concours` WHERE article_gagnant IS NULL");
        while($res = mysqli_fetch_array($query4))
            $article_pour .= ($res_article['id_concours']==$res['semestre_édition'] && !$res_article['numero_journal']) ?  "<option name='$res[semestre_édition]' value='$res[semestre_édition]' selected>Concours $res[semestre_édition]</option>" : 
            "<option name='$res[semestre_édition]' value='$res[semestre_édition]'>Concours $res[semestre_édition]</option>";
                

        if($status=="brouillon"){
            $status_show = "édition <i class='icon icon-edit'></i>";
            $links = array('current','','','','','','','','');
            $buttons_update_status[0]= "<form action='' method='post'><button type='submit' value='valider' name='brouillon' />Soumettre</button></form>";
        }else if($status=="correction"){
            $status_show = "en correction <i class='icon icon-search'></i>";
            $links = array('done','done','current','','','','','','');
            if(secure_session('is_admin') || own_article($id))
                $buttons_update_status[1]= "<form action='' method='post'><button type='submit' value='valider' name='corrige' />Corrigé</button></form>";
        }else if($status=="validation_admin"){
            $status_show = "en attente de validation par un admin <i class='icon icon-hammer'></i>";
            $links = array('done','done','done','done','current','','','','');
            if(secure_session('is_admin'))
                $buttons_update_status[2] = "<form action='' method='post'><button type='submit' value='valider' name='valider_admin'/>Valider</button><br/><button type='submit' value='refuser' name='refuser_admin'>Refuser</button></form>";
        }else if($status=="validation_pvdc"){
            $status_show = "en attente de validation par le PVDC <i class='icon icon-hammer'></i>";
            $links = array('done','done','done','done','done','done','current','','');
            if(secure_session('is_pvdc') || secure_session('is_admin'))
                $buttons_update_status[3] = "<form action='' method='post'><button type='submit' value='valider' name='valider_pvdc' />Valider</button><br/><button type='submit' value='refuser' name='refuser_pvdc'>Refuser</button></form>";
        }else if($status=="attente_publication"){
            $status_show = "en attente de publication <i class='icon icon-edit'></i>";
            $links = array('done','done','done','done','done','done','done','done','current');
            if(secure_session('is_admin') && !$res_article['numero_journal'])
                $buttons_update_status[4] = "<form action='' method='post'><button type='submit' value='valider' name='publier'/>Publier</button></form>";
        }else if($status=="publié"){
            $status_show = "publié <i class='icon icon-note'></i>";
            $links = array('done','done','done','done','done','done','done','done','done');
        }else if($status=="refusé_admin"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = array('done','done','done','done','refused','','','','');
        }else if($status=="refusé_pvdc"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = array('done','done','done','done','done','done','refused','','');
            if(secure_session('is_pvdc') || secure_session('is_admin'))
                $buttons_update_status[3] = "<form action='' method='post'><button type='submit' value='valider' name='valider_pvdc' />Valider</button></form>";
        }else{
                $status_show = "NaN";
                $links = array('','','','','','','','','');
        };

        $disabled = can_article_be_edited($id) ? "" : "disabled";
        echo "<section id='new_article'>";
        echo "<h1 id='actual_status'>Statut : $status_show</h1>";
        echo "<table id='evolution_status'>
                <tr>
                    <td class='circle draft'><div alt='Brouillon'><span class='$links[0]'></span></div></td>
                    <td class='link'><div class='$links[1]'></div></td>
                    <td class='circle correction' alt='Correction'><div><span class='$links[2]'></span></div></td>
                    <td class='link'><div class='$links[3]'></div></td>
                    <td class='circle validation_admin' alt='Validation admin'><div><span class='$links[4]'></span></div></td>
                    <td class='link'><div class='$links[5]'></div></td>
                    <td class='circle validation_pvdc' alt='Validation pvdc'><div><span class='$links[6]'></span></div></td>
                    <td class='link'><div class='$links[7]'></div></td>
                    <td class='circle publication' alt='Publication'><div><span class='$links[8]'></span></div></td>
                </tr>
                <tr id='explications_steps'>
                    <td>Brouillon</td>
                    <td></td>
                    <td>Correction</td>
                    <td></td>
                    <td>Validation</br>admin</td>
                    <td></td>
                    <td>Validation</br>PVDC</td>
                    <td></td>
                    <td>Publication</td>
                </tr>
                <tr id='update_status'>
                    <td>$buttons_update_status[0]</td>
                    <td></td>
                    <td>$buttons_update_status[1]</td>
                    <td></td>
                    <td>$buttons_update_status[2]</td>
                    <td></td>
                    <td>$buttons_update_status[3]</td>
                    <td></td>
                    <td>$buttons_update_status[4]</td>
                </tr>
            </table>";
                           
        echo "<form action='' method='post' id='edit_form'>";
        echo "<h1 onclick='toggle_section(1);'>L'article<i id='section1_icon' class='icon icon_open_close icon-up-open'></i></h1>";
        echo "<div class='togglable_section' id='section1'>
        <div class='input'><h2>Titre : </h2><input $disabled type='text' name='titre' id='titre' value='$res_article[titre]'/></div>
        <div class='input'><h2>Sous-titre : </h2><input $disabled type='text' name='soustitre' id='soustitre' value='$res_article[sous_titre]'/></div>
        <h2>Contenu :</h2>
        <textarea class='contenu' $disabled name='contenu' onkeypress='update_preview();' id='contenu'>$res_article[texte_contenu]</textarea>
        <h2>Prévisualisation de l'article</h2>
        <section id='article_content'></section>
        <script type='text/javascript'> window.addEventListener('load', function() {
            update_preview();
        })
       </script>

        </div>";

        echo "<h1 onclick='toggle_section(2);'>Détails de l'article<i id='section2_icon' class='icon icon_open_close icon-up-open'></i></h1>";
        echo "<div class='togglable_section' id='section2'>
        <h2>Description courte :</h2>
        <textarea $disabled class='courte_description' name='courte_description'>$res_article[courte_description]</textarea>
        <div class='input'><h2>URL image couverture : </h2><input $disabled type='text' name='image_couverture' id='image_couverture' value='$res_article[image_couverture]'/></div>
        <h2>Genre : </h2><select name='genre' $disabled>$liste_genre</select>
        <h2>Registre : </h2><select name='registre' $disabled>$liste_registres</select>
        </div>";
        
        echo "<h1 onclick='toggle_section(3);'>Paramètres de publication<i id='section3_icon' class='icon icon_open_close icon-up-open'></i></h1>";
        echo "<div class='togglable_section' id='section3'>
        <h2>Anonymat auteur : </h2><select $disabled class='anonymat_auteur' name='anonymat_auteur'><br/>";
        echo ($res_article['anonymat_auteur']) ? "<option name='oui' value='1' selected >Oui</option><option name='non' value='0'>Non</option>"
        : "<option name='oui' value='1'>Oui</option><option name='non' value='0' selected>Non</option>";
        echo "</select><br/><h2>Reservé abonné : </h2><select $disabled class='reserve_abonne' name='reserve_abonne' >";
        echo ($res_article['réservé_abonné']) ? "<option selected value='1' name='oui'>Oui</option><option value='0' name='non'>Non</option>" :
        "<option name='oui' value='1'>Oui</option><option value='0' selected name='non'>Non</option>";
        echo "</select><br/><h2>Article publié pour : </h2>
        <select class='article_pour' $disabled name='article_pour'>
        $article_pour</select><br/>
        <h2>Rubrique : </h2><select $disabled name='rubrique'>$liste_rubriques</select>
        </div>";
        if(!$disabled)
            echo "<p><button type='submit' class='update_button' name='update_button' method='post'>Mettre à jour</button></p>";

        echo "</form>";
        if($status!="publié" || own_article($id) || secure_session('is_admin')){
            $query_feed = mysqli_query($connect,"SELECT * FROM `lf_historique` WHERE idarticle = $id ORDER BY `date` ASC");
            while($res_feed = mysqli_fetch_array($query_feed))
            {
                if($res_feed['login'] == $res_article['auteur'] && $res_article['anonymat_auteur'] && (($res_feed['color'] != "8ff05f" || ($res_feed['content']=="Article soumis à correction"|| $res_feed['content']=="Article corrigé, soumis a la validation d'un admin")) && $res_feed['color'] != "f44a4a"))
                    $autor_comment = "auteur article";
                else
                    $autor_comment = $res_feed['login'];
                edit_article_feed($res_feed['content'], $autor_comment, $res_feed['date'], $res_feed['color']);
            }
            echo "<div class='link_feed'><span></span></div>";
            echo "<div class='message' style=\"background-color: #cecece;\" ><form method='post' action=''><textarea  id='comment' name='message'></textarea>
            <p><button type='submit' class='update_button' name='send_comment' method='post'>Envoyer le commentaire</button></p></form></div>";
        }
        echo "</section>";
    }

    function edit_article_feed($content, $autor, $date, $color)
    {
        echo "<div class='link_feed'><span></span></div>";
        echo "<div class='message' style=\"background-color: #$color;\"><p>$content</p><span class='details'>par $autor le $date</span></div>";
    }
?>