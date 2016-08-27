<?php
    require("main/page2.php");
require("../lib/database.php");
    Page2::header("");
?><br>
    
    <div class="container">
        <?php
       
            $jugo="<div class='row'>
             <div class='parallax'>
                 <!--img src='img/parallax/zumo_de_fruta.jpeg'-->
           </div>";
            $sql='select * from ingrediente order by nombre';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row)
            {
                $jugo.="<div class='col s4'><div class='card large'>
                <div class='card-image waves-effect waves-block waves-light'>
                  <img class='activator hovereffect responsive-img' src='data:image/*;base64,$row[imagen]'>
                </div>
                <div class='card-content'>
                  <span class='card-title activator grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>more_vert</i></span>
                </div>
                <div class='card-reveal'>
                  <span class='card-title grey-text text-darken-4'>$row[nombre]<i class='material-icons right'>close</i></span>
                  <p>$row[descripcion]</p>
                </div>
              </div></div>
                ";
            }
        $jugo.="</div>";
        print($jugo);
        
        
        ?>
    </div>
    <br>
    <?php page2::footer();?>
    
    