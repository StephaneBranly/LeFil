<?php

    function numero($id_numero){
        return "<div class='numero' onclick=\"RedirectionJavascript('./numero-$id_numero');\">
                        <div class='container'>
                        <div class='book'>
                            <div class='front'>
                                <div class='cover'>
                                    <img alt='image de couverture' src='../ressources/covers/Le Fil $id_numero.png'/>
                                    <!--<p class=author>Le Fil, numéro $id_numero</p>-->
                                </div>
                            </div>
                            <div class='left-side'>
                                <h2>
                                    <span>Le Fil</span>
                                    <span>numéro $id_numero</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>";
        
    }
    
    function numeros($number_to_display=NULL){
        global $connect;
        $numero_content = '';
        echo "<div id='numeros'>";
        if($number_to_display==NULL)
        {
            $query = mysqli_query($connect,"SELECT * FROM `lf_journaux` WHERE numéro < 417 ORDER BY `numéro` DESC ");
            echo "<h1 id='numero_before'>Tous nos numéros :</h1>";
        }
        else
        {
            echo "<h1 id='numero_before'>Nos derniers numéros :</h1>";
            $query = mysqli_query($connect,"SELECT * FROM `lf_journaux` WHERE numéro < 417 ORDER BY `numéro` DESC LIMIT $number_to_display");

        }
        while($res = mysqli_fetch_array($query))
            $numero_content .= numero($res['numéro']);
        echo "$numero_content</div>";

    }
?>