<?php
    function can_edit_article($id)
    {
        return 1;
    }

    function edit_article($id)
    {
        global $connect;
        $buttons_update_status = ['','','','',''];
        $status = 'brouillon';

        $liste_genre = "<option name='-'>---</option>";
        $query0 = mysqli_query($connect,"SELECT genre FROM `lf_genre` WHERE etat=1");
        while($res = mysqli_fetch_array($query0))
            $liste_genre .= "<option name='$res[genre]'>$res[genre]</option>";
        
        $liste_rubriques = "<option name='-'>---</option>";
        $query1 = mysqli_query($connect,"SELECT rubrique FROM `lf_rubriques` WHERE etat=1");
        while($res = mysqli_fetch_array($query1))
            $liste_rubriques .= "<option name='$res[rubrique]'>$res[rubrique]</option>";

        $liste_registres = "<option name='-'>---</option>";
        $query2 = mysqli_query($connect,"SELECT registre FROM `lf_registres` WHERE etat=1");
        while($res = mysqli_fetch_array($query2))
            $liste_registres .= "<option name='$res[registre]'>$res[registre]</option>";

        if($status=="brouillon"){
            $status_show = "édition <i class='icon icon-edit'></i>";
            $links = ['current','','','','','','','',''];
            $buttons_update_status[0]= "<button>Soumettre</button>";
        }else if($status=="correction"){
            $status_show = "en correction <i class='icon icon-search'></i>";
            $links = ['done','done','current','','','','','',''];
            $buttons_update_status[1]= "<button>Corrigé</button>";
        }else if($status=="validation_admin"){
            $status_show = "en attente de validation par un admin <i class='icon icon-hammer'></i>";
            $links = ['done','done','done','done','current','','','',''];
            $buttons_update_status[2] = "<button>Valider</button><br/><button>Refuser</button>";
        }else if($status=="validation_pvdc"){
            $status_show = "en attente de validation par le PVDC <i class='icon icon-hammer'></i>";
            $links = ['done','done','done','done','done','done','current','',''];
            $buttons_update_status[3] = "<button>Valider</button><br/><button>Refuser</button>";
        }else if($status=="attente_publication"){
                $status_show = "en attente de publication <i class='icon icon-edit'></i>";
                $links = ['done','done','done','done','done','done','done','done','current'];
                $buttons_update_status[4] = "<button>Valider</button><br/><button>Refuser</button>";
        }else if($status=="publié"){
                $status_show = "publié <i class='icon icon-note'></i>";
                $links = ['done','done','done','done','done','done','done','done','done'];
        }else if($status=="refusé_admin"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = ['done','done','done','done','refused','','','',''];
        }else if($status=="refusé_pvdc"){
            $status_show = "refusé <i class='icon icon-cancel-circled2'></i>";
            $links = ['done','done','done','done','done','done','refused','',''];
        }else{
                $status_show = "NaN";
                $links = ['','','','','','','','',''];
        };
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
        <div class='input'><h2>Titre : </h2><input type='text' name='titre' id='titre'/></div>
        <div class='input'><h2>Sous-titre : </h2><input type='text' name='soustitre' id='soustitre'/></div>
        <h2>Contenu :</h2>
        <textarea class='contenu' name='contenu' onkeypress='update_preview();' id='contenu'></textarea>
        <h2>Prévisualisation de l'article</h2>
        <section id='article_content'></section>
        </div>";

        echo "<h1 onclick='toggle_section(2);'>Détails de l'article<i id='section2_icon' class='icon icon_open_close icon-up-open'></i></h1>";
        echo "<div class='togglable_section' id='section2'>
        <h2>Description courte :</h2>
        <textarea class='courte_description'name='courte_description'></textarea>
        <h2>Genre : </h2><select name='genre'>$liste_genre</select>
        <h2>Registre : </h2><select name='registre'>$liste_registres</select>
        </div>";
        
        echo "<h1 onclick='toggle_section(3);'>Paramètres de publication<i id='section3_icon' class='icon icon_open_close icon-up-open'></i></h1>";
        echo "<div class='togglable_section' id='section3'>
        <h2>Anonymat auteur : </h2><select class='anonymat_auteur' name='anonymat_auteur'><option name='oui'>Oui</option><option name='non'>Non</option></select>
        <h2>Reservé abonné : </h2><select class='reserve_abonne' name='reserve_abonne'><option name='oui'>Oui</option><option name='non'>Non</option></select>
        <h2>Article publié pour : </h2><select class='article_pour' name='article_pour'><option name='oui'>Le Fil 423</option><option name='non'>Hors-Série</option></select>
        <h2>Rubrique : </h2><select name='rubrique'>$liste_rubriques</select>
        </div>";
        echo "<p><button class='update_button' method='post'>Mettre à jour</button></p>";

        echo "</form>";
        edit_article_feed(2, "tu devrais corriger bonjur en bonjour", "stephane", "correction", "ajd");
        edit_article_feed(2, "tu devrais corriger bonjur en bonjour", "stephane", "correction", "ajd");
        echo "</section>";
    }

    function edit_article_feed($id_feed, $content, $autor, $type, $date)
    {
        echo "<div class='link_feed'><span></span></div>";
        echo "<div class='message'><p>$content</p><span class='details'>par $autor le $date</span></div>";
    }
?>