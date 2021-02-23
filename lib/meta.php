<?php
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
    if(isset($nom_page) && isset($description_page))
    {
        echo"<title>Le Fil - $nom_page</title>
        <meta name='Language' content='fr'/>
        <meta name='Description' content=\"$description_page\"/>
        <meta name='Keywords' content='$nom_page, lefil, journal, étudiant, UTC, Universite de Technologie de Compiegne'>
        <meta name='Robots' content='all'>";
    }
?>