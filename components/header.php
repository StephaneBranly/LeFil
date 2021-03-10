<?php    
    function _header(){
    echo"<header>
        <div id='logo' onclick=\"open_link('../accueil');\"><img  src='../ressources/images/logo.png' alt='Logo LeBonCup'/></div>";
    
    if(secure_session('connected')==false)
    {
        echo"<div id='login'><span onclick=\"RedirectionJavascript('pages/log.php?section=login',0);\"><i class='icon-user-pair'></i>Se connecter</span></div>";
    }
    else 
    {
        $user=secure_session('user');
        $username=secure_session('username');
        echo"<div id='login'>";
        echo"<span onclick=\"view_profile('$user');\"><i class='icon-address-card-o'></i>$username</span><span onclick=\"RedirectionJavascript('logout',0);\"><i class='icon-user-pair'></i>Se déconnecter</span></div>";
    }
    echo "</header><div id='header_wave_container'><div class='wave'></div></div>";

    notifications();
    } 
?>