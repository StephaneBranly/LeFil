<?php
    function role($r){
        echo "<div><span class='role $r[role]'>$r[role]</span><span class='login'>$r[login]</span></div>";
    }
    function gestion_roles(){
        global $connect;

        echo "<form action='' method='post'>
            <span>login :</span><input name='login'/>
            <select name='role'><option value='correcteur'>correcteur</option><option value='redacteur'>redacteur</option><option value='pvdc'>pvdc</option></select>
            <select name='action'><option value='ADD'>Ajouter</option><option value='DELETE'>Supprimer</option></select>
            <button type='submit' name='upd'>Mettre a jour</button>
        </form>";
        
        if(isset($_POST['upd'])){
            $login = secure_post('login');
            $action = secure_post('action');
            $role = secure_post('role');
            if($role=="correcteur" || $role=="redacteur" || $role=="pvdc")
            {
                if($action=="ADD")
                    $upd_roles = mysqli_query($connect,"INSERT INTO `lf_roles` (`login`, `role`) VALUES ('$login', '$role');");
                else if($action=="DELETE")
                    $upd_roles = mysqli_query($connect,"DELETE FROM `lf_roles` WHERE `lf_roles`.`login` = '$login' AND `lf_roles`.`role` = '$role'");
            }
        }
        echo "<section id='gestion_roles'>";
        $query_roles = mysqli_query($connect,"SELECT * FROM `lf_roles` ORDER BY `role` ASC");
        while($res_role = mysqli_fetch_array($query_roles))
            role($res_role);
        echo "</section>";
    }
?>