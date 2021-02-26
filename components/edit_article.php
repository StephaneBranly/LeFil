<?php
    function can_edit_article($id)
    {
        return 1;
    }

    function edit_article($id)
    {
        echo "<section id='new_article'>";

       
        echo "<form action='' method='post' class='main_content edit_form'>";
        echo "<h1>L'article</h1>";
        echo "<div class='input'><input type='text' name='titre' id='titre'/></div>"; 
        echo "<div class='input'><input type='text' name='soustitre' id='soustitre'/></div>"; 
        echo "<textarea class='contenu' name='contenu'></textarea>";
        echo "<p><button class='update_button' method='post'>Mettre à jour cette partie</button></p>";
        echo  "</form>";

        echo "<form action='' method='post' class='categories edit_form'>";
        echo "<h1>Détails de l'article</h1>";
        echo "<textarea class='courte_description' name='courte_description'></textarea>";
        echo "<select class='anonymat_auteur' name='anonymat_auteur'><option name='oui'>Oui</option><option name='non'>Non</option></select>";
        echo "<select class='reserve_abonne' name='reserve_abonne'><option name='oui'>Oui</option><option name='non'>Non</option></select>";
        echo "<p><button class='update_button' method='post'>Mettre à jour cette partie</button></p>";
        echo "</form>";

        echo "<form action='' method='post' class='categories edit_form'>";
        echo "<h1>Paramètres de publications</h1>";
        echo "<textarea class='courte_description' name='courte_description'></textarea>";
        echo "<div class='input'>Anonymat auteur : <select class='anonymat_auteur' name='anonymat_auteur'><option name='oui'>Oui</option><option name='non'>Non</option></select></div>";
        echo "<div class='input'>Reservé abonné : <select class='reserve_abonne' name='reserve_abonne'><option name='oui'>Oui</option><option name='non'>Non</option></select></div>";
        echo "<div class='input'>Article publié pour : <select class='article_pour' name='article_pour'><option name='oui'>Le Fil 423</option><option name='non'>Hors-Série</option></select></div>";
        echo "<p><button class='update_button' method='post'>Mettre à jour cette partie</button></p>";

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