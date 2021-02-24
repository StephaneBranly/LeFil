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

        echo "<div id='container_display_numero'>
        <section id='display_numero'>
        <div id='title'>Le Fil, numéro $numero</div>
        <section id='content'><div id='left_side'>";
        echo "<div class='article active' id='page_de_couverture' onClick=\"change_article('page_de_couverture')\">Page de couverture</div>";
        $query = mysqli_query($connect,"SELECT identifiant, titre FROM `lf_articles` WHERE `numero_journal`=$numero");
        while($res = mysqli_fetch_array($query))
            echo "<div class='article' id='article-$res[identifiant]' onClick=\"change_article('article-$res[identifiant]','$res[identifiant]');\">$res[titre]</div>";
        echo "</div>";
        echo "<div id='right_side' class='article_content'></div>";
        echo "</section></section></div>";

        echo "<script type='text/javascript' src='../components/services/numero.js'></script>";

    }

?>