


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/avstemming02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
</head>

<body> 
  <img id="video_bilde" src="media/bg5.jpg" alt="video_bilde">
  
<?php
    include_once 'header.php';




    if(!isset($_SESSION['epost'])){
        header('Location: logginn.php');
    } elseif (date("Y-m-d H:i:s", $intStartvalg) >= date("Y-m-d H:i:s") || date("Y-m-d H:i:s", $intSluttvalg) <= date("Y-m-d H:i:s")) {
        header('Location: default.php');
    }
?>

  <main>
    <main id="contener">
        <form id="serch_form" action='avstemming.php' method='POST'>
            <input id="serch"  type="text" placeholder="Search.." name="search" autofocus>
            <button id="serch_knapp" type="submit">Søk!</button>
        </form>
        
 
        <article id="tabel">
  
        <table>
            <tr><!--Dette er tabell header-->
                <th>Stemm</th> <!--Tabell Header-->
                    <th>Kandidat</th>
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


            $sql = "SELECT kandidat.bruker, bruker.fnavn, bruker.enavn, trukket FROM kandidat LEFT JOIN bruker ON kandidat.bruker = bruker.epost HAVING bruker LIKE :brukerId";
          
            $stmt = $db->prepare($sql);
            $aaa ="%";
            if (isset($_POST['search'])){
              $aaa ="%".$_POST['search']."%";
            }
            $stmt->bindParam(':brukerId', $aaa);
            $stmt->execute();


            foreach ($stmt->fetchAll() as $row) {


                if (substr($row['bruker'],-7) == "@usn.no"){
                    if ($row['trukket'] == "j" || $row['trukket'] == "J" || $row['trukket'] == "1"  || $row['trukket'] == "y"  || $row['trukket'] == "Y"){
                        $kandidater = '<tr><td class="td1">Trukket seg ut</td>'.
                        '<td><a target="_blank" href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].' ('.$row['fnavn'].' '.$row['enavn'].')</a></td></tr>';
                        echo($kandidater);

                    }else{

                        if ($stemme === $row['bruker']){
                            $kandidater = '<tr><td class="td1"><form action="avstemming.php" method="POST"><input type="hidden" name="tu">'.
                            '<button id="submit_knapp2" type="submit">Trekk ut</button></td></form>'.
                            
                            '<td><a target="_blank" href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].' ('.$row['fnavn'].' '.$row['enavn'].')</a></td></tr>';
                            echo($kandidater);
                        }else{
                    
                            $kandidater = '<tr><td class="td1"><form action="avstemming.php" method="POST"><input type="hidden" name="st" value="'.$row['bruker'].'">'.
                            '<button id="submit_knapp" type="submit">Stemm</button></td></form>'.
                            
                            '<td><a target="_blank" href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].' ('.$row['fnavn'].' '.$row['enavn'].')</a></td></tr>';
                            echo($kandidater);
                        }
                    }
                }else{
                    $kandidater = '<tr><td class="td1">Ugyldig</td>'.
                    
                    '<td><a target="_blank" href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].' ('.$row['fnavn'].' '.$row['enavn'].')</a></td></tr>';
                    echo($kandidater);
                }
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

</body>
</html>



