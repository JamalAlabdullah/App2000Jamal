


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/nominering02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
</head>

<body> 
  <img id="video_bilde" src="media/bg4.jpg" alt="video_bilde">
  
<?php

    include_once 'header.php';
   
    if(!isset($_SESSION['epost'])){
        header('Location: logginn.php');
    } elseif (date("Y-m-d H:i:s", $intStartforslag) >= $idag || date("Y-m-d H:i:s", $intSluttforslag) <= $idag) {
        header('Location: default.php');
  
    } else {
        $bildeNavn = "$_SERVER[QUERY_STRING]";
        if (date("Y-m-d H:i:s", $intStartforslag) > $idag){
            $error = 'Nominasjon er stengt!';
            header("refresh: 1");
        }elseif(date("Y-m-d H:i:s", $intSluttforslag) <= $idag){
            $error = 'Nominasjon er stengt!';
        
        }else{
        if (isset($_POST['epost'])){
            if (empty($_POST['epost'])){
                $_POST['epost']=$brukerId;
            }if (empty($_POST['fakultet'])){
                $_POST['fakultet']=null; 
            }if (empty($_POST['institutt'])){
                $_POST['institutt']=null; 
            }if (empty($_POST['informasjon'])){
                $_POST['informasjon']=null;
            }if (empty($_POST['bilde'])){
                $_POST['bilde']="defaultA.jpg";
            }if (substr($_POST['epost'],-7) == "@usn.no"){

                $sql = "SELECT * FROM kandidat WHERE bruker = :brukerId";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':brukerId', $_POST['epost']);
                    $stmt->execute();
                    $finnes = False;
                    if ($stmt->rowCount()){
                        $finnes = True;
                    }
                    foreach ($stmt->fetchAll() as $row) {
                        $trukket = $row['trukket'];
                    }

                    if ($trukket == "j" || $trukket == "J" || $trukket == "1"  || 
                        $trukket == "y"  || $trukket == "Y"){
                            
                        if ($_POST['epost'] === $_SESSION['epost']){
                            $sql = "UPDATE `valg2021`.`kandidat` SET `trukket` = NULL WHERE (`bruker` = :brukerId);";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':brukerId', $_SESSION['epost']);
                            $stmt->execute();
                            $melding ='Du ble igjen kandidat';
                        }else{
                            $error = 'kandidaten har trukket seg ut!';
                        }
                    }else{
                        if ($finnes){$error = 'kandidaten er allerede registrert';}
                        else{

                            $sql = "SELECT * FROM bruker WHERE epost = :brukerId";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':brukerId', $_POST['epost']);
                            $stmt->execute();

                            if ($stmt->rowCount()){
                        

                                $sql = "select MAX(idbilde)+1 as a from bilde";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                foreach ($stmt->fetchAll() as $row) {
                                    $idbilde = $row['a'];
                                }
                    
                                $sql = "INSERT INTO `valg2021`.`bilde` (`idbilde`, `hvor`, `tekst`, `alt`)";
                                $sql.= " VALUES (:idbilde, :bnavn, :bildeNavn, :balt)";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':bnavn', $_POST['epost']);
                                $stmt->bindParam(':idbilde', $idbilde);
                                $stmt->bindParam(':bildeNavn', $_POST['bilde']);
                                $balt= $fornavn." bilde";
                                $stmt->bindParam(':balt', $balt);
                                $stmt->execute();

                    
                                $sql = "INSERT INTO `valg2021`.`kandidat` (`bruker`, `fakultet`, `institutt`, `informasjon`, `bilde`)";
                                $sql.= " VALUES (:bnavn, :fakultet, :institutt, :informasjon, :idbilde)";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':bnavn', $_POST['epost']);
                                $stmt->bindParam(':fakultet', $_POST['fakultet']);
                                $stmt->bindParam(':institutt', $_POST['institutt']);
                                $stmt->bindParam(':informasjon', $_POST['informasjon']);
                                $stmt->bindParam(':idbilde', $idbilde);
                                $stmt->execute();
                                $melding = $_POST['epost'].' ble registrert';
                            }else{
                                $error = 'Brukeren finnes ikke!';
                            }
                        }
                    }
                }else{$error = 'Oppgi riktig e-postadresse ***@usn.no';}
            }
        }
    }
?>

  <main>
    <main id="contener">
    <?php if (isset($error) || isset($melding)){ ?>
        <article id="tabel_med_feilMelding">
    <?php } else{ ?>
        <article id="tabel">
    <?php } ?>
        <table>
            <tr><!--Dette er tabell header-->
                <th>Alle registrerte kandidater</th>
            </tr>
            <?php
            $sql = "select kandidat.bruker, bruker.fnavn, bruker.enavn, trukket from kandidat left join bruker ON kandidat.bruker = bruker.epost";
            foreach ($db->query($sql) as $row) {
                if ($row['trukket'] == "j" || $row['trukket'] == "J" || $row['trukket'] == "1"  || $row['trukket'] == "y"  || $row['trukket'] == "Y"){
                    $kandidater = "<tr><td>".$row['bruker']." <span class='Ugyeldig' >*trukket seg ut</span></td></tr>";

                    
                }else{
                    $kandidater = "<tr><td>".$row['bruker']." (".$row['fnavn']." ".$row['enavn'].")</td></tr>";
                }
                echo($kandidater);
            }
            ?>
   
        </table>
    </article>
    


        <?php if (isset($error) || isset($melding)){ ?>
            <article id="border_med_feilMelding">
        <?php } else{ ?>
            <article id="border">
        <?php } ?>
        <form action='nominering.php' method='POST'>
        
            <?php if($bildeNavn!=""){ ?>
                <img id="bilde" type="image" src="katalog/<?php echo $bildeNavn ?>" />
            <?php }else{ ?>
                <img id="bilde" type="image" src= "media/defaultA.jpg" />
            <?php }?>
                <img id="editbilde" type="image" src="media/editIcon.png" />

            
            <section id="inputer">
            <label class="label" >Bruker <span style="color: red;"> *<span></label><!--label Brukernavn-->
            <input class="innData" type="email" name="epost" value= "<?php echo $brukerId ?>" placeholder="Oppgi e-post" autofocus><!--innData brukernavn-->
            <label class="label" >Fakultet</label><!--label Passord-->
            <input class="innData" type="text" name="fakultet" placeholder="Oppgi fakultet"><!--innData fakultet-->
            <label class="label" >Institutt</label><!--label Passord-->
            <input class="innData" type="text" name="institutt" placeholder="Oppgi institutt"><!--innData institutt-->
            <label class="label" >Om kandidaten</label>
            <textarea class="innData" id="text" name="informasjon" type="text" placeholder="text..."></textarea>
            <?php if (isset($error)){ ?>
                <input class="innData" id="feilMelding" type="text" value=" <?php echo "* ".$error; ?>" readonly>
            <?php } ?>
            <?php if (isset($melding)){ ?>
                <input class="innData" id="melding" type="text" value=" <?php echo "* ".$melding; ?>" readonly>
            <?php } ?>
            <button id="submit_knapp" type="submit" name="submit" value="login">Legge til</button>
            </section>
            <input style="visibility: hidden;" type="text" name="bilde" value="<?php echo $bildeNavn ?>" >
            
        </form>
        <form enctype="multipart/form-data" action="php-include/uploadBilde.php?nominering" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000"/>
            <input style="opacity: 0; cursor: pointer;" id="editbilde_knapp" name="uploadedfile" type="file" onchange="this.form.submit()"/><br />
            <input style="visibility: hidden; " type="submit"/>
        </form>
        
    </article>
    <?php 
    if (date("Y-m-d H:i:s", $intStartforslag) > $idag){
    ?>
        <article id="Nborder">
            <h2 id="Ntitle">Nominasjon er stengt!</h2>
            <h3 id="Ndate">Åpner: <?php echo $startforslag ?></h3>
            <?php 
            
            function time_fallende($sekunder){
                $liste = array(
                    'år' => $sekunder / 31556926 % 12,
                    'uke' => $sekunder / 604800 % 52,
                    'd' => $sekunder / 86400 % 7,
                    't' => $sekunder / 3600 % 24,
                    'm' => $sekunder / 60 % 60,
                    's' => $sekunder % 60
                    );
                   
                foreach($liste as $i => $n)
                    $liste_text[] = $n . $i;
                   
                return join(' / ', $liste_text);
                }
            ?>
            <h3 id="Nsoon"><?php echo time_fallende($intStartforslag-time())?></h3>

        </article>
        <?php } ?>
        <?php if ( date("Y-m-d H:i:s", $intSluttforslag) <= $idag){?>
            <article id="Nborder">
            <h2 id="Ntitle">Nominasjon er sluttet!</h2>
            <h3 id="Ndate">Sluttet dato: <?php echo $sluttforslag ?></h3>
            </article>
        <?php } ?>

    </main>
</main>
    

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>



