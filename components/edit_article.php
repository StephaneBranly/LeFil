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
        if($res['statut']!='brouillon' && secure_session(is_admin()))
            return 1;
        return 0;
    }

    function own_article($id_article){
        global $connect;
        $current_user = secure_session('user');
        $query_author = mysqli_query($connect,"SELECT auteur FROM `lf_écrit` WHERE `article`=$id_article AND `auteur`='$current_user'");
        $res_author = mysqli_fetch_array($query_author);
        return ($res_author && count($res_author));
    }

    function edit_article($id)
    {
        global $connect;
        $buttons_update_status = ['','','','',''];

        $query_article = mysqli_query($connect,"SELECT * FROM `lf_articles` WHERE identifiant=$id");
        $res_article = mysqli_fetch_array($query_article);

        $status = $res_article['statut'];
        $current_login = secure_session('user');

        if($status=='brouillon' && isset($_POST['brouillon']) && own_article($id)){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'correction' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),'Article soumis à correction','8ff05f','icon-search')");
        }else if($status=='correction' && isset($_POST['corrige']) && (secure_session('is_correcteur') || secure_session('is_admin')) && !own_article($id)){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'validation_admin' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article corrigé, soumis a la validation d'un admin\",'8ff05f','icon-search')");
        }else if(($status=='validation_admin' || $status='refusé_admin') && isset($_POST['valider_admin']) && secure_session('is_admin')){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'validation_pvdc' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article validé par l'admin, soumis a la validation du PVDC\",'8ff05f','icon-search')");
        }else if($status=='validation_admin' && isset($_POST['refuser_admin']) && secure_session('is_admin')){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'refusé_admin' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article refusé par l'admin\",'f44a4a','icon-search')");
        }else if(($status=='validation_pvdc' || $status='refusé_pvdc') && isset($_POST['valider_pvdc']) && (secure_session('is_admin') || secure_session('is_pvdc'))){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'attente_publication' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article validé par le PVDC, en attente de publication\",'8ff05f','icon-search')");
        }else if($status=='validation_pvdc' && isset($_POST['refuser_pvdc']) && (secure_session('is_admin') || secure_session('is_pvdc'))){
            $query_upd = mysqli_query($connect,"UPDATE `lf_articles` SET `statut` = 'refusé_pvdc' WHERE `identifiant`= $id");
            $query_histo = mysqli_query($connect,"INSERT INTO `lf_historique`(`idarticle`, `login`, `date`, `content`,`color`,`icon`) VALUES ($id,'$current_login',NOW(),\"Article refusé par le PVDC\",'f44a4a','icon-search')");
        }

        if(isset($_POST['update_button']) && can_article_be_edited($id)){
            $titre = secure_post('titre');
            $soustitre = secure_post('soustitre');
            $contenu = secure_post('contenu');
            $description_courte = secure_post('courte_description');
            $genre = secure_post('genre');
            $registre = secure_post('registre');
            $rubrique = secure_post('rubrique');
            $image_couverture = secure_post('image_couverture');
            $anonymat_auteur = secure_post('anonymat_auteur');
            $reserve_abonne = secure_post('reserve_abonne');
            $article_pour = secure_post('article_pour');

            if($genre=='-') $genre = 'null';
            if($rubrique=='---') $rubrique = 'null';
            if($registre=='---') $registre = 'null';
            if($soustitre=='---') $soustitre = 'null';
            
            $query_upd_content = mysqli_query($connect,"UPDATE `lf_articles` SET `titre` = '$titre', `sous_titre` = '$soustitre', 
            `courte_description` = '$description_courte', `texte_contenu` = '$contenu',
             `image_couverture` = '$image_couverture', `id_rubrique` = $rubrique, 
             `id_registre` = '$registre', `id_genre` = '$genre', `id_concours` = '1', `numero_journal` = 1, `réservé_abonné` = $reserve_abonne, `anonymat_auteur` = $anonymat_auteur WHERE `lf_articles`.`identifiant` = $id"); 
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
        $query3 = mysqli_query($connect,"SELECT numéro, date_publication FROM `lf_journaux` WHERE statut='en_attente'");
        while($res = mysqli_fetch_array($query3))
            $article_pour .= ($res_article['numero_journal']==$res['numéro']) ?  "<option name='$res[numéro]' value='$res[numéro]' selected>Le Fil $res[numéro] (publication prévue le $res[date_publication])</option>" : 
            "<option name='$res[numéro]' value='$res[numéro]'>Le Fil $res[numéro] (publication prévue le $res[date_publication])</option>";
            $query3 = mysqli_query($connect,"SELECT numéro, date_sortie FROM `lf_journaux` WHERE statut='brouillon'");
        
        $query4 = mysqli_query($connect,"SELECT semestre_édition FROM `lf_concours` WHERE article_gagnant IS NULL");
        while($res = mysqli_fetch_array($query4))
            $article_pour .= ($res_article['id_concours']==$res['semestre_édition'] && !$res_article['numero_journal']) ?  "<option name='$res[semestre_édition]' value='$res[semestre_édition]' selected>Concours $res[semestre_édition]</option>" : 
            "<option name='$res[semestre_édition]' value='$res[semestre_édition]'>Concours $res[semestre_édition]</option>";
                

        if($status=="brouillon"){
            $status_show = "édition <i class='icon icon-edit'></i>";
            $links = ['current','','','','','','','',''];
            $buttons_update_status[0]= "<form action='' method='post'><button type='submit' value='valider' name='brouillon' />Soumettre</button></form>";
        }else if($status=="correction"){
            $status_show = "en correction <i class='icon icon-search'></i>";
            $links = ['done','done','current','','','','','',''];
            if((secure_session('is_correcteur') || secure_session('is_admin')) && !own_article($id))
                $buttons_update_status[1]= "<form action='' method='post'><button type='submit' value='valider' name='corrige' />Corrigé</button></form>";
        }else if($status=="validation_admin"){
            $status_show = "en attente de validation par un admin <i class='icon icon-hammer'></i>";
            $links = ['done','done','done','done','current','','','',''];
            if(secure_session('is_admin'))
                $buttons_update_status[2] = "<form action='' method='post'><button type='submit' value='valider' name='valider_admin'/>Valider</button><br/><button type='submit' value='refuser' name='refuser_admin'>Refuser</button></form>";
        }else if($status=="validation_pvdc"){
            $status_show = "en attente de validation par le PVDC <i class='icon icon-hammer'></i>";
            $links = ['done','done','done','done','done','done','current','',''];
            if(secure_session('is_pvdc') || secure_session('is_admin'))
                $buttons_update_status[3] = "<form action='' method='post'><button type='submit' value='valider' name='valider_pvdc' />Valider</button><br/><button type='submit' value='refuser' name='refuser_pvdc'>Refuser</button></form>";
        }else if($status=="attente_publication"){
            $status_show = "en attente de publication <i class='icon icon-edit'></i>";
            $links = ['done','done','done','done','done','done','done','done','current'];
            if(secure_session('is_admin'))
                $buttons_update_status[4] = "<form action='' method='post'><button type='submit' value='valider' name='publier'/>Publier</button></form>";
        }else if($status=="publié"){
            $status_show = "publié <i class='icon icon-note'></i>";
            $links = ['done','done','done','done','done','done','done','done','done'];
        }else if($status=="refusé_admin"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = ['done','done','done','done','refused','','','',''];
        }else if($status=="refusé_pvdc"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = ['done','done','done','done','done','done','refused','',''];
            if(secure_session('is_pvdc') || secure_session('is_admin'))
                $buttons_update_status[3] = "<form action='' method='post'><button type='submit' value='valider' name='valider_pvdc' />Valider</button></form>";
        
        }else{
                $status_show = "NaN";
                $links = ['','','','','','','','',''];
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
        <textarea class='contenu' $disabled name='contenu' onload='update_preview();'; onkeypress='update_preview();' id='contenu'>$res_article[texte_contenu]</textarea>
        <h2>Prévisualisation de l'article</h2>
        <section id='article_content'></section>
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
        <h2>Anonymat auteur : </h2><select $disabled class='anonymat_auteur' name='anonymat_auteur'>";
        echo ($res_article['anonymat_auteur']) ? "<option name='oui' value='1' selected >Oui</option><option name='non' value='0'>Non</option>"
        : "<option name='oui' value='1'>Oui</option><option name='non' value='0' selected>Non</option>";
        echo "</select><h2>Reservé abonné : </h2><select $disabled class='reserve_abonne' name='reserve_abonne' >";
        echo ($res_article['réservé_abonné']) ? "<option selected value='1' name='oui'>Oui</option><option value='0' name='non'>Non</option>" :
        "<option name='oui' value='1'>Oui</option><option value='0' selected name='non'>Non</option>";
        echo "</select><h2>Article publié pour : </h2>
        <select class='article_pour' $disabled name='article_pour'>
        $article_pour</select>
        <h2>Rubrique : </h2><select $disabled name='rubrique'>$liste_rubriques</select>
        </div>";
        if(!$disabled)
            echo "<p><button type='submit' class='update_button' name='update_button' method='post'>Mettre à jour</button></p>";

        echo "</form>";
        $query_feed = mysqli_query($connect,"SELECT * FROM `lf_historique` WHERE idarticle = $id ORDER BY `date` ASC");
        while($res_feed = mysqli_fetch_array($query_feed))
        {
            edit_article_feed($res_feed['content'], $res_feed['login'], $res_feed['date'], $res_feed['color']);
        }
        echo "</section>";
    }

    function edit_article_feed($content, $autor, $date, $color)
    {
        echo "<div class='link_feed'><span></span></div>";
        echo "<div class='message' style=\"background-color: #$color;\"><p>$content</p><span class='details'>par $autor le $date</span></div>";
    }
?>