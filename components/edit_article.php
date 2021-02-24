<?php
    function can_edit_article($id)
    {
        return 1;
    }

    function edit_article($id)
    {
        echo "<section id='new_article'>";
        echo "<form action='' method='post'>";
        echo "<div class='input'><input type='text' name='title' id='title'/></div>"; 
        echo "<div class='input'><input type='text' name='subtitle' id='subtitle'/></div>"; 
        echo "<textarea name='content'></textarea>";
        echo "<a id='preview' href=''>Prévisualiser l'article</a>";
        echo  "</form>";
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