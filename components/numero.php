<?php
    function can_numero_be_read($id_numero)
    {
        global $connect;
        $query = mysqli_query($connect,"SELECT statut FROM `lf_journaux` WHERE `numéro`=$id_numero");
        $res = mysqli_fetch_array($query);
        if((!$res || $res['statut']!='publié') && !is_admin())
            return 0;
        return 1;
    }


    function read_numero($numero){
        global $connect;

        $query_pdf = mysqli_query($connect,"SELECT lien_pdf FROM `lf_journaux` WHERE `numéro`=$numero");
        $res_pdf = mysqli_fetch_array($query_pdf);
        $link = ($res_pdf && $res_pdf['lien_pdf']) ? "<a href='../ressources/pdf/$res_pdf[lien_pdf]' target='_blank' class='button_pdf_dl'><i class='icon  icon-attach'></i>Numéro disponible en PDF !</a>" : "";

        echo "<div id='container_display_numero'>
        <section id='display_numero'>
        <div id='title'>Le Fil, numéro $numero $link</div>
        <section id='content'><div id='left_side'>";

        if(file_exists("../ressources/covers/Le Fil $numero.png"))
        {
            $second_tab_active = "";
            $first_to_display = "page_de_couverture";
            echo "<script type='text/javascript'>let active_article = 'page_de_couverture'; let image_file = '../ressources/covers/Le Fil $numero.png';</script>";
            echo "<div class='article active' id='page_de_couverture' onClick=\"change_article('page_de_couverture')\">Page de couverture</div>";
        }  
        else 
        {
            $second_tab_active = "active";
        }

        $query = mysqli_query($connect,"SELECT identifiant, titre FROM `lf_articles` WHERE `numero_journal`=$numero");
        $index = 0;
        while($res = mysqli_fetch_array($query))
        {
            if($index==0)
            {
                echo "<script type='text/javascript'>let active_article = 'article-$res[identifiant]';</script>";
                echo "<div class='article $second_tab_active' id='article-$res[identifiant]' onClick=\"change_article('article-$res[identifiant]','$res[identifiant]');\">$res[titre]</div>";
                if($second_tab_active!=""){
                    $second_tab_active = $res['identifiant'];
                    $first_to_display = "article-$res[identifiant]";
                }
                
            }
            else
                echo "<div class='article' id='article-$res[identifiant]' onClick=\"change_article('article-$res[identifiant]','$res[identifiant]');\">$res[titre]</div>";
            $index+=1;
        }
        echo "</div>";
        echo "<div id='right_side' class='article_content'></div>";
        echo "</section></section></div>";

        echo "<script type='text/javascript' src='../components/services/numero.js'></script>";
        echo "<script type='text/javascript'>change_article('$first_to_display','$second_tab_active')</script>";
    }
?>