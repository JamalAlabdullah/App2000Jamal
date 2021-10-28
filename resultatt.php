


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/resultatt02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
</head>

<body> 
  <img id="video_bilde" src="media/bg5.jpg" alt="video_bilde">
  
<?php
    include_once 'header.php';



    if(!isset($_SESSION['epost'])){
        header('Location: logginn.php');
    }
    if ((date("Y-m-d H:i:s", $intKontrollert) < $idag  && $intKontrollert !="") || $brukertype == 3 || $brukertype == 2){
    
?>

  <main>
    <main id="contener">
        <form id="serch_form" action='resultatt.php' method='POST'>
            <input id="serch"  type="text" placeholder="Search.." name="search" >
            <button id="serch_knapp" type="submit">Søk!</button>
            
        </form>
        
 
        <article id="tabel">
  
        <table>
            <tr><!--Dette er tabell header-->
                
                    <th>Kandidat</th>
                    <th>Gjeldige<br>stemmer</th>
                    <th>Ugjeldige<br>stemmer</th>
                
                </tr>
            </tr>
            <?php

        
       
            
            
            
            
            $sql = "SELECT bruker, COUNT(Gyldig) AS antallGyldig, COUNT(Ugyldig) AS antallUgyldig, trukket";
            $sql.= " FROM kandidat left join ( SELECT epost, stemme,";
            $sql.= " CASE WHEN epost LIKE '%usn.no' THEN 'Gyldig' END AS Gyldig,";
            $sql.= " CASE WHEN epost NOT LIKE '%usn.no' THEN 'Gyldig' END AS Ugyldig";
            $sql.= " FROM bruker) AS aa ON bruker = stemme GROUP BY bruker ";
            $sql.= " HAVING kandidat.bruker LIKE :brukerId  AND bruker !='' ORDER BY antallGyldig DESC;";


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

                      $kandidater = '<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].'</a> <span class="Ugyeldig" >*Trukket seg ut</span></td>'.
                        '<td>'.$row['antallGyldig'].'</td>'.
                        '<td>'.$row['antallUgyldig'].'</td>'.
                        '</tr>';
                        echo($kandidater);

                    }else{
                      $kandidater = '<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].'</a></td>'.
                      '<td>'.$row['antallGyldig'].'</td>'.
                      '<td>'.$row['antallUgyldig'].'</td>'.
                      '</tr>';
                      echo($kandidater);
                    }
                }else{
                  $kandidater = '<tr><td><a href="presentasjonKandidat.php?'.$row['bruker'].'" id="a">'.$row['bruker'].'</a> <span class="Ugyeldig" >*Ugyldig</span></td>'.
                    '<td>'.$row['antallGyldig'].'</td>'.
                    '<td>'.$row['antallUgyldig'].'</td>'.
                    '</tr>';
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


<?php }else{header('Location: logginn.php');}?>
