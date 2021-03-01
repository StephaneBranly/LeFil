<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php"); ?>
<?php 
    $query = mysqli_query($connect,"SELECT * FROM `lf_écrit`");
    while($res = mysqli_fetch_array($query))
    {
        $queryUPD = mysqli_query($connect,"UPDATE `lf_articles` SET `auteur` = '$res[auteur]' WHERE `lf_articles`.`identifiant` = $res[article]");
    }
    echo "OK.";
?>