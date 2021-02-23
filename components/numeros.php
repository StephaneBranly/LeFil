<?php

    function numero($id_numero){
        return "<div class='numero'>
                        <div class='container'>
                        <div class='book'>
                            <div class='front'>
                                <div class='cover'>
                                    <p class=author>Le Fil, numéro $id_numero</p>
                                </div>
                            </div>
                            <div class='left-side'>
                                <h2>
                                    <span>Le Fil hebdo</span>
                                    <span>$id_numero</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>";
        
    }
    
    function numeros($number_to_display=NULL){
        global $connect;
        $numero_content = '';
        if($number_to_display==NULL)
            $query = mysqli_query($connect,"SELECT * FROM `lf_journaux` ORDER BY `numéro` DESC");
        else
            $query = mysqli_query($connect,"SELECT * FROM `lf_journaux` ORDER BY `numéro` DESC LIMIT $number_to_display");
        while($res = mysqli_fetch_array($query))
            $numero_content .= numero($res['numéro']);
        echo "<div id='numeros'>$numero_content</div>";

    }
?>