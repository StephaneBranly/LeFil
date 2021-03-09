<?php
    function articles_profile($user){
        global $connect;

        if(secure_session('connected') && secure_session('user')==$user)
        {
            echo "<section id='articles_profile'>";
            $tabs = "";

            $tabs .= "<span onclick=\"change_article_tab_profile_user('mes-articles');\" id='mes-articles' class='active'>Mes articles</span>";
            if(secure_session('is_correcteur') || secure_session('is_admin'))
                $tabs .= "<span onclick=\"change_article_tab_profile_user('correction');\" id='correction'>Correction</span>";
            if(secure_session('is_admin'))
                $tabs .= "<span onclick=\"change_article_tab_profile_user('admin');\" id='admin'>A valider (admin)</span>";
            if(secure_session('is_pvdc') || secure_session('is_admin'))
                $tabs .= "<span onclick=\"change_article_tab_profile_user('pvdc');\" id='pvdc'>A valider (PVDC)</span>";
            if(secure_session('is_admin'))
                $tabs .= "<span onclick=\"change_article_tab_profile_user('attente_publication');\" id='attente_publication'>Attente publication</span>";


            echo "<div id='nav'>$tabs</div>";

            // MES ARTICLES TAB
            echo "<section id='content_mes-articles'>";
            $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles` WHERE `auteur`='$user' ORDER BY `date_parution` DESC");
            while($res_article = mysqli_fetch_array($query_articles)){
                article_mini($res_article['identifiant'],own_article($res_article['identifiant']));
            }
            echo "</section>";

            // ARTICLES CORRECTION TAB
            if(secure_session('is_correcteur') || secure_session('is_admin'))
            {
                echo "<section id='content_correction' style=\"display: none;\">";
                $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles`  WHERE statut='correction' ORDER BY `date_parution` DESC");
                while($res_article = mysqli_fetch_array($query_articles)){
                    article_mini($res_article['identifiant'],1);
                }
                echo "</section>";
            }

            // ARTICLES ADMIN TAB ET ATTENTE_PUBLICATION
            if(secure_session('is_admin'))
            {
                echo "<section id='content_admin' style=\"display: none;\">";
                $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles` WHERE statut='validation_admin' OR statut='refusé_admin' ORDER BY `date_parution` DESC ");
                while($res_article = mysqli_fetch_array($query_articles)){
                    article_mini($res_article['identifiant'],1);
                }
                echo "</section>";

                echo "<section id='content_attente_publication' style=\"display: none;\">";
                $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles` WHERE statut='attente_publication' ORDER BY `date_parution` DESC ");
                while($res_article = mysqli_fetch_array($query_articles)){
                    article_mini($res_article['identifiant'],1);
                }
                echo "</section>";
            }

             // ARTICLES PVDC TAB
             if(secure_session('is_pvdc') || secure_session('is_admin'))
             {
                 echo "<section id='content_pvdc' style=\"display: none;\">";
                 $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles` WHERE statut='validation_pvdc' OR statut='refusé_pvdc' ORDER BY `date_parution` DESC ");
                 while($res_article = mysqli_fetch_array($query_articles)){
                     article_mini($res_article['identifiant'],1);
                 }
                 echo "</section>";
             }

            echo "</section>";
        }
        else
        {
            echo "<section id='articles_profile'>";
            echo "<h1>Les articles de cet auteur :</h1>";
            $query_articles = mysqli_query($connect,"SELECT `identifiant` FROM `lf_articles` WHERE `auteur`='$user' ORDER BY `date_parution` DESC");
            while($res_article = mysqli_fetch_array($query_articles)){
                article_mini($res_article['identifiant']);
            }
            echo "</section>";
        }
    }



?>