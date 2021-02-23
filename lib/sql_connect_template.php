<!-- 
  REMOVE _template in the file name
  Configure it with your database
-->
<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'pass';
    $dbname = 'name';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting tomysql');
    mysqli_query($connect,"SET NAMES UTF8");
    mysqli_set_charset($connect,"UTF8");

function SQLProtect($var,$bool){
  //$bool = true si la var doit etre un texte et false si la variable doit etre un nombre
  if($bool){
    return addslashes($var);
  }else{
    return intval($var);
  }
}

function SQLProtectPrice($var){
  return round($var,2);
}
 ?>