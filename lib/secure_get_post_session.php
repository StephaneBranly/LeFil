<?php
    function secure_get($id)
    {
        if(isset($_GET[$id]))
        {
            $get = $_GET[$id];
            return $get;
        }
        else return null;
    }
    function secure_post($id)
    {
        if(isset($_POST[$id]))
        {
            $post = $_POST[$id];
            return $post;
        }
        else return null;
    }
    function secure_session($id)
    {
        if(isset($_SESSION[$id]))
        {
            $session = $_SESSION[$id];
            return $session;
        }
        else return null;
    }
?>