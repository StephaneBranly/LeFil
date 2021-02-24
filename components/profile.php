<?php    
    function profile($user){
        global $connect;
        $edit=secure_get('edit');
        $user=strtolower(SQLProtect($user,true));
        $query = mysqli_query($connect,"SELECT * FROM `lf_users` WHERE `iduser`='$user'");
        $res = mysqli_fetch_array($query);
        if (count($res) != 0)
        {
            if($edit==1 && $user==secure_session('user') && secure_session('connected'))
            {
                $redirect=true;

                $username=$res['username'];
                $mail=$res['mail'];

                if(isset($_POST['username']))
                {
                    $username=SQLProtect(remove_balise(secure_post('username')),1);
                    $mail=SQLProtect(remove_balise(secure_post('mail')),1);

                    if(strlen ($username)>25 || $username=="")
                    {
                        echo "<script type='text/javascript'>write_notification('icon-cancel-circled','Le username doit faire entre 1 et 25 caractères',10000)</script>";
                        $redirect=false;
                    }
                    if(strlen ($mail)>50)
                    {
                        echo "<script type='text/javascript'>write_notification('icon-cancel-circled','Le mail doit faire moins de 50 caractères',10000)</script>";
                        $redirect=false;
                    }
                }   
                else
                    $redirect=false;

                if($redirect)
                {
                    $_SESSION['username']=$username;
                    $query = mysqli_query($connect,"UPDATE `lf_users` 
                    SET `username` = '$username',
                     `mail` = '$mail',
                     WHERE iduser = '$user'");
                    echo "<script type='text/javascript'>RedirectionJavascript('profile/$user',100);</script>";
                    $_SESSION['notification_icon']='icon-floppy';
                    $_SESSION['notification_new']=true;
                    $_SESSION['notification_content']="Modification effectuée";
                }
                echo "<section id='profile'>
                <h1>Profil de $username</h1>
                <form action='../profile/$user-edit' method='post'>
                <h2>Informations compte</h2>
                <table id='informations'>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>ID utilisateur</td><td class='info_value'>$res[iduser]</td>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>Username</td><td class='info_value an_input'><input maxlenght='25' type='text' name='username' placeholder='username' value='$username'/></td>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>Mail</td><td class='info_value an_input'><input maxlenght='50' type='text' name='mail' placeholder='mail' value='$mail'/></td>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>Date création du compte</td><td class='info_value'>$res[creation_account]</td>
                    <tr><td class='info_property'><i class='icon-clock'></i>Dernière connexion</td><td class='info_value'>$res[last_connexion]</td>
                </table>
                <button type='submit' id='button_submit'>VALIDER<i class='icon-ok-circled2'></i></button>
                </form><br/>";
                if($res['mail_news'])
                    echo "<a target='_blank' class='mailing_list' href='../unsubscribe/$user/news/$res[mail_news]'>Se désabonner de la newsletter</a>";
                else
                    echo "<a target='_blank' class='mailing_list' href='../subscribe/$user/news'>S'abonner à la newsletter</a>";
                echo "</section>";
            }
            else
            {
                echo "<section id='profile'>";
                if($user==secure_session('user') && secure_session('connected'))
                    echo"<div id='owner'><span onclick=\"open_link('../profile/$user-edit');\"><i class='icon-pencil'></i>Editer le profil</span></div>";
                echo"<h1>Profil de $res[username]</h1>
                <h2>Informations compte</h2>
                <table id='informations'>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>ID utilisateur</td><td class='info_value'>$res[iduser]</td>
                    <tr><td class='info_property'><i class='icon-user-pair'></i>Username</td><td class='info_value'>$res[username]</td>";
                    if($user==secure_session('user') && secure_session('connected'))
                        echo"<tr><td class='info_property'><i class='icon-user-pair'></i>Mail</td><td class='info_value'>$res[mail]</td>";
                    echo"<tr><td class='info_property'><i class='icon-user-pair'></i>Date création du compte</td><td class='info_value'>$res[creation_account]</td>
                    <tr><td class='info_property'><i class='icon-clock'></i>Dernière connexion</td><td class='info_value'>$res[last_connexion]</td>
                </table>
                </section>";

                if($user==secure_session('user') && secure_session('connected'))
                    echo "<section><a class='button_link' href='../edit-article-new'>Rédiger un nouvel article</a></section>";
            }
        }
    } 
?>