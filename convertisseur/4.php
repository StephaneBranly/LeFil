<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php"); ?>
<?php 
    $query = mysqli_query($connect,"SELECT * FROM `lf_événement`");
    while($res = mysqli_fetch_array($query))
    {
        $queryUPD = mysqli_query($connect,"UPDATE `lf_journaux` SET `date_publication` = '$res[date]' WHERE `lf_journaux`.`date_sortie` = $res[identifiant]");
    }
    echo "OK.";
?>