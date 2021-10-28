<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/presentasjonKandidat02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>

</head>

<body> 
  <img id="video_bilde" src="media/bg3.jpg" alt="video_bilde">
  
 
<?php
 
    include_once 'header.php';
    if(!isset($_SESSION['epost'])){
        header('Location: default.php');
    }
    $epost = "$_SERVER[QUERY_STRING]";

    $sql = "SELECT kandidat.*, bruker.* FROM kandidat LEFT JOIN bruker ON kandidat.bruker = bruker.epost HAVING bruker = :brukerId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':brukerId', $epost);
        $stmt->execute();
    
        
        foreach ($stmt->fetchAll() as $row) {
           
            $fornavn = $row['fnavn'];
            $etternavn = $row['enavn'];
            $fodselsdato = $row['fdato'];
            if ($row['mann'] === "M"){$kjonen = "Mann";}
            elseif ($row['mann'] === "K"){$kjonen = "Kvinne";}
            elseif ($row['mann'] === "A"){$kjonen = "Andre";}
            else {$kjonen = $row['mann'];};

            $Fakultet = $row['fakultet'];
            $Institutt = $row['institutt'];
            $OmKandidaten = $row['informasjon'];
            $bildeID = $row['bilde'];
        }

        $sql = "SELECT * FROM bilde WHERE idbilde = :bilde";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bilde', $bildeID);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $row) {
            $bilde = $row['tekst'];
        }

?>




  <main id="main" class="visible">
      <article id="border">
            <?php if($bildeID==""){?>
                <img id="bilde" type="image" src= "media/defaultA.jpg" />
            <?php }else{ ?>
                <img id="bilde" type="image" src="katalog/<?php echo $bilde ?>" alt="profil bilde: <?php echo $bilde ?>"/>
            <?php } ?>
    
                

            <section id="inputer">
                
                <label class="label" >Fornavn: <span><?php echo $fornavn?></span></label>
              
                <label class="label" >Etternavn: <span><?php echo $etternavn?></span></label>
                <label class="label" >epost: <span><?php echo $epost?></span></label>
                <label class="label" >Fødselsdato: <span><?php echo $fodselsdato?></span></label>
               
                <label class="label">Kjønn: <span><?php echo $kjonen?></span></label>
                <label class="label">Fakultet: <span><?php echo $Fakultet ?></span></label>
                <label class="label">Institutt: <span><?php echo $Institutt?></span></label>
                <label class="label" id="lab">Om <?php echo $fornavn?>:</label>
                <textarea id="text" cols="30"><?php echo $OmKandidaten ?></textarea>
             
            </section>
        
        
          
      
      




      
        
    </article>



  </main>

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>

