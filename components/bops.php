<?php

function bops($uv,$content,$date){
    echo "<div class='bops-unit'><span class='uv'>$uv</span><span class='content'>$content</span><span class='date'>Le $date</span></div>";
}
function new_bops(){
    global $connect;

    $uv = SQLProtect(secure_post('uv'),1);
    $content = SQLProtect(secure_post('content'),1);
    if(isset($_POST['envoyer_bops']))
    {
        if(!$uv || !$content)
            echo "<script type='text/javascript'>write_notification('icon-cancel-circled','Tous les champs doivent être remplis.',10000)</script>";
        else
        {
            $uv = strtoupper($uv);
            $query_add = mysqli_query($connect,"INSERT INTO `lf_bop_s` (`identifiant`, `uv`, `contenu`, `date`, `modération`) VALUES (NULL, '$uv', '$content', NOW(), '0'); ");
            echo "<script type='text/javascript'>write_notification('icon-note',\"Le BOP's a bien été envoyé ! Merci\",10000)</script>";
            $uv = "";
            $content = "";
        }
    }
    echo "<section id='new_bops'><h1>Envoie ton BOP's !</h1><form action='' method='post'>
            <input value='$uv' required name='uv' placeholder='UV' maxlength='4' size='4'/>
            <textarea name='content' required placeholder=\"Contenu BOP'S\">$content</textarea> 
            <button name='envoyer_bops' type='submit' method='post'>Envoyer</button>
            </section>";
}

function all_bops(){
    global $connect;
    $query = mysqli_query($connect,"SELECT * FROM `lf_bop_s` WHERE `modération`=1 ORDER BY `date` DESC");
    echo "<div id='bops_only'><h1>Les BOP's</h1><section>";
    while($res = mysqli_fetch_array($query))
       bops($res['uv'],$res['contenu'],$res['date']);
    echo "</section></div>";
}
?>