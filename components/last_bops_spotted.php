<?php

function bops_mini($uv,$content,$date){
    return "<div class='bops-mini'><span class='uv'>$uv</span><span class='content'>$content</span><span class='date'>Le $date</span></div>";
}
function spotted_mini($content,$date){
    return "<div class='spotted-mini'><span class='content'>$content</span><span class='date'>Par un anonyme, le $date</span></div>";
}
function last_bops_spotted(){
    global $connect;
    echo "<div class='wave-container-bs'><div class='wave-top'></div></div>";
    echo "<section id='last_bops_spotted'>";

    $query = mysqli_query($connect,"SELECT * FROM `lf_bop_s` WHERE `modération`=1 ORDER BY `date` DESC LIMIT 5");
    $bops="";
    while($res = mysqli_fetch_array($query))
        $bops .= bops_mini($res['uv'],$res['contenu'],$res['date']);
    echo "<div id='bops'><h1>Les derniers BOP's</h1><section>$bops</section><p class='button-section'><a href='../bop_s' class='button_link'>Page BOP's</a></p></div>";

    $query = mysqli_query($connect,"SELECT * FROM `lf_spotted` WHERE `modération`=1 ORDER BY `date` DESC LIMIT 3");
    $spotted="";
    while($res = mysqli_fetch_array($query))
        $spotted .= spotted_mini($res['contenu'],$res['date']);
    echo "<div id='spotted'><h1>Les derniers spotted</h1><section>$spotted</section><p class='button-section'><a href='../spotted' class='button_link'>Page Spotted</a></p></div>";

    echo "</section>";
    echo "<div class='wave-container-bs'><div class='wave-bottom'></div></div>";
}
?>