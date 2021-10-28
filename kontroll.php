


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/kontroll02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
</head>

<body> 
  <img id="video_bilde" src="media/bg5.jpg" alt="video_bilde">
  
<?php
    include_once 'header.php';




    if(!isset($_SESSION['epost']) || $brukertype != 3 || date("Y-m-d H:i:s", $intSluttvalg) > $idag){
        header('Location: logginn.php');
    }
?>

  <main>
    <main id="contener">
        <form id="serch_form" action='kontroll.php' method='POST'>
            <input id="serch"  type="text" placeholder="Search.." name="search" autofocus>
            <button id="serch_knapp" type="submit">Søk!</button>
        </form>
        
 
        <article id="tabel">
  
        <table>
            <tr><!--Dette er tabell header-->
                <th>Kandidater</th> <!--Tabell Header-->
                    <th>Valgere</th>
                </tr>
            </tr>
            <?php

            if(isset($_POST['st'])){
                $sql = "UPDATE `valg2021`.`bruker` SET `stemme` = :tt WHERE (`epost` = :bnavn);";
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':tt', $_POST['st']);
                $stmt->bindParam(':bnavn', $brukerId);
                $stmt->execute();
                header("refresh: 0"); 
            }
            
            if(isset($_POST['tu'])){
                $sql = "UPDATE `valg2021`.`bruker` SET `stemme` = NULL WHERE (`epost` = :bnavn);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':bnavn', $brukerId);
                $stmt->execute();
                header("refresh: 0"); 
            }


            
          
            
    
            
            $sql = "SELECT bruker, COUNT(Gyldig) AS antallGyldig, COUNT(Ugyldig) AS antallUgyldig, trukket";
            $sql.= " FROM kandidat left join ( SELECT epost, stemme,";
            $sql.= " CASE WHEN epost LIKE '%usn.no' THEN 'Gyldig' END AS Gyldig,";
            $sql.= " CASE WHEN epost NOT LIKE '%usn.no' THEN 'Gyldig' END AS Ugyldig";
            $sql.= " FROM bruker) AS aa ON bruker = stemme AND bruker !='' GROUP BY bruker HAVING bruker LIKE :brukerId ORDER BY antallGyldig DESC";

            $stmt = $db->prepare($sql);
            $aaa ="%";
            if (isset($_POST['search'])){
              $aaa ="%".$_POST['search']."%";
            }
            $stmt->bindParam(':brukerId', $aaa);
            $stmt->execute();

            $tall=0;
            foreach ($stmt->fetchAll() as $row) {
                
                $tall++;
                if (substr($row['bruker'],-7) == "@usn.no"){

                    if ($row['trukket'] == "j" || $row['trukket'] == "J" || $row['trukket'] == "1"  || $row['trukket'] == "y"  || $row['trukket'] == "Y"){

                        echo('<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a" target="_blank"->'.$row['bruker'].'</a><br><span class="td1">Trukket seg ut</span></td><td>');
                        echo('<button class="gyldige_knapper" onclick="gyldige'.$tall.'()">Gyldige stemmer: ('.$row['antallGyldig'].')</button>');
                        echo('<p style="display: none;" id="a'.$tall.'">');
  
                    }else{
                        echo('<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a" target="_blank"->'.$row['bruker'].'</a></td><td>');
                        echo('<button class="gyldige_knapper" onclick="gyldige'.$tall.'()">Gyldige stemmer: ('.$row['antallGyldig'].')</button>');
                        echo('<p style="display: none;" id="a'.$tall.'">');
                    }
                }else{
                    echo('<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a" target="_blank"->'.$row['bruker'].'</a><br><span class="td1">Ugyldig bruker</span></td><td>');
                    echo('<button class="gyldige_knapper" onclick="gyldige'.$tall.'()">Gyldige stemmer: ('.$row['antallGyldig'].')</button>');
                    echo('<p style="display: none;" id="a'.$tall.'">');
                }
                    $sql2 = "SELECT * FROM bruker WHERE stemme = :stemmet";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam(':stemmet', $row['bruker']);
                    $stmt2->execute();
                    $s=false;
                    foreach ($stmt2->fetchAll() as $row2) {
                        if (substr($row2['epost'],-7) == "@usn.no"){
                            $s=true;
                            echo('<a href="presentasjonKandidat.php?'.$row2['epost'].'" id="a" target="_blank">'.$row2['epost'].'</a><br>');
                        }
                    }if ($s==false){echo('Ingen');}
                    echo('</p><br>');

                    echo('<button class="ugyldige_knapper" onclick="ugyldige'.$tall.'()">Ugyldige stemmer: ('.$row['antallUgyldig'].')</button><p style="display: none;" id="b'.$tall.'">');

                    $sql2 = "SELECT * FROM bruker WHERE stemme = :stemmet";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam(':stemmet', $row['bruker']);
                    $stmt2->execute();
                    $s=false;
                    foreach ($stmt2->fetchAll() as $row2) {
                        if (substr($row2['epost'],-7) != "@usn.no"){
                            $s=true;
                            echo('<a href="presentasjonKandidat.php?'.$row2['epost'].'" id="a" target="_blank">'.$row2['epost'].'</a><br>');
                        }
                    }if ($s==false){echo('Ingen');}
                    
                    echo('</p><br>');
                    echo('</td></tr>');
            }
           
            ?>
 
   
        </table>
        
    </article>

    </main>
</main>
    

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

  <script>


<?php
for ($id = 1; $id <= $tall; $id++) {
?>

function gyldige<?php echo $id; ?>() {
        var x = document.getElementById("a<?php echo $id; ?>");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function ugyldige<?php echo $id; ?>() {
        var x = document.getElementById("b<?php echo $id; ?>");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

<?php } ?>

</script>   
 
</body>
</html>

