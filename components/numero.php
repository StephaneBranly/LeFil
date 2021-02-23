<?php
    function read_numero($numero){
        global $connect;

        echo "<div id='container_display_numero'>
        <section id='display_numero'>
        <div id='title'>Le Fil, numéro $numero</div>
        <section id='content'><div id='left_side'>";
        echo "<div class='article active' id='page_de_couverture' onClick=\"change_article('page_de_couverture')\">Page de couverture</div>";
        $query = mysqli_query($connect,"SELECT * FROM `lf_contient` INNER JOIN `lf_articles` ON lf_contient.article = lf_articles.identifiant WHERE `journal`=$numero");
        while($res = mysqli_fetch_array($query))
            echo "<div class='article' id='article-$res[identifiant]' onClick=\"change_article('article-$res[identifiant]','$res[identifiant]');\">$res[titre]</div>";
        echo "</div>";
        echo "<div id='right_side'></div>";
        echo "</section></section></div>";

        echo "<script type='text/javascript' src='../components/services/numero.js'></script>";

    }

?>