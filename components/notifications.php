<?php    
    function notification($id,$content,$icon)
    {
        echo"<div class='notification entrance' id='notification_$id'
        onclick='remove_notification($id)'>
            <i class='$icon'></i>
            <p>$content</p>
        </div>";
    }

    function notifications(){   
        global $connect;
        echo"<section id='notifications'>";
        if(secure_session('notification_new'))
        {
            notification(0,secure_session('notification_content'),secure_session('notification_icon'));
            $_SESSION['notification_new']=false;
        }
        if(secure_session("connected") && strpos($_SERVER['REQUEST_URI'], "/pages/log.php")===false)
        {
            $user=secure_session("user");
            $query = mysqli_query($connect,"SELECT * FROM `lf_notifications`  WHERE iduser = '$user' AND `viewed` = 0 ORDER BY `date` DESC");
            while($res = mysqli_fetch_array($query))
            {
                $idnotif = $res['idnotif'];
                notification($idnotif,$res['content'],$res['icon']);
                $query2 = mysqli_query($connect,"UPDATE `lf_notifications` SET `viewed` = 1 WHERE `idnotif`= $res[idnotif]");  
            }
                
        }
        echo"</section>";
    }
?>