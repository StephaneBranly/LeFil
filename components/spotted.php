<?php

function spotted($content,$date){
    echo "<div class='spotted-unit'><span class='content'>$content</span><span class='date'>Le $date</span></div>";
}
function new_spotted(){
    global $connect;

    $content = SQLProtect(secure_post('content'),1);
    if(isset($_POST['envoyer_spotted']))
    {
        if(!$content)
            echo "<script type='text/javascript'>write_notification('icon-cancel-circled','Tous les champs doivent être remplis.',10000)</script>";
        else
        {
            $uv = strtoupper($uv);
            $query_add = mysqli_query($connect,"INSERT INTO `lf_spotted` (`identifiant`, `contenu`, `date`, `modération`) VALUES (NULL, '$content', NOW(), '0'); ");
            echo "<script type='text/javascript'>write_notification('icon-note',\"Le Spotted a bien été envoyé ! Merci\",10000)</script>";
            $uv = "";
            $content = "";
        }
    }
    echo "<section id='new_spotted'><h1>Envoie ton Spotted !</h1><form action='' method='post'>
            <textarea name='content' required placeholder=\"Contenu Spotted\">$content</textarea> 
            <button name='envoyer_spotted' type='submit' method='post'>Envoyer</button>
            </section>";
}

function all_spotted(){
    global $connect;
    $query = mysqli_query($connect,"SELECT * FROM `lf_spotted` WHERE `modération`=1 ORDER BY `date` DESC");
    echo "<div id='spotted_only'><h1>Les Spotted</h1><section>";
    while($res = mysqli_fetch_array($query))
       spotted($res['contenu'],$res['date']);
    echo "</section></div>";
}
?>