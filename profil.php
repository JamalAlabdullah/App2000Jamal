<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/profil02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>

</head>

<body> 
  <img id="video_bilde" src="media/bg1.jpg" alt="video_bilde">
  
 
  <?php

include_once 'header.php';
if(!isset($_SESSION['epost'])){
    header('Location: default.php');
} else {
    $checked="";
    if($kandidat === "ja" && date("Y-m-d H:i:s", $intStartforslag) <= $idag && date("Y-m-d H:i:s", $intSluttforslag) > $idag){
        header('Location: profilKandidat.php');
    }



    if (isset($_POST['fornavn'])){
        if (empty($_POST['fornavn'])){
            $_POST['fornavn']=$brukerId;
        }if (empty($_POST['etternavn'])){
            $_POST['etternavn']=null;
        }if (empty($_POST['kjonn'])){
            $_POST['kjonn']=null;
        }if (empty($_POST['fdato'])){
            $_POST['fdato']=null;
        }if (empty($_POST['passord'])){
            $error = "Oppgi passord";
        }else {
            $salt = sha1("IT2_2021".$_POST['passord']);
            if ($regPass == $salt){
            
                $sql.= " VALUES (:bnavn, :pass, :enavn, :fnavn, '1', :fdato, :mann)";
            
                $sql = "UPDATE `valg2021`.`bruker` SET `enavn` = :enavn, `fnavn` = :fnavn, `fdato` = :fdato, `mann` = :mann";
                $sql.= " WHERE (`epost` = :bnavn);";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':enavn', $_POST['etternavn']);
                $stmt->bindParam(':fnavn', $_POST['fornavn']);
                $stmt->bindParam(':fdato', $_POST['fdato']);
                $stmt->bindParam(':mann', $_POST['kjonn']);
                $stmt->bindParam(':bnavn', $brukerId);
                $stmt->execute();
                $melding = 'Profilen oppdates';
                header("refresh: 1"); 
            }else {
                $error = "Oppgi riktig passord";
            }
        }
    }
}

?>




  <main id="main" class="visible">
    <?php if (isset($error) || isset($melding)){ ?>
      <article id="border_med_feilMelding">
    <?php } else{ ?>
      <article id="border">
    <?php } ?>

        <form action='profil.php' method='POST'>
            <section id="inputer">
                <label class="label" >Fornavn</label>
                <input class="innData" type="text" name="fornavn" placeholder="Oppgi Fornavn" value= "<?php echo $fornavn ?>" autofocus>
                <label class="label" >Etternavn</label>
                <input class="innData" type="text" name="etternavn" placeholder="Oppgi Etternavn" value= "<?php echo $etternavn ?>" >


                <label class="label">Kjønn: </label>
                <i class="label knapper">
                    <input type="radio" name="kjonn" value="M" <?php if($kjonen==="M"){$checked = "checked"; echo $checked; } ?>> <!-- Mann -->
                    <label for="Mann">Mann</label>
                    <input type="radio" name="kjonn" value="K" <?php if($kjonen==="K"){$checked = "checked"; echo $checked; } ?>> <!-- Kvinne -->
                    <label for="Kvinne">Kvinne</label>
                    <input type="radio" name="kjonn" value="A" <?php if($kjonen==="A"){$checked = "checked"; echo $checked; } ?>> <!-- Andre -->
                    <label for="Andre">Andre</label>
                </i>
                    <label class="label" >Fødselsdato</label>
                    <input class="innData" type="date" name="fdato" placeholder="Oppgi fdato"  value= "<?php echo $fodselsdato ?>">

                    <label class="label" >Bekreftelse</label>
                    <input class="innData" type="password" name="passord" placeholder="Oppgi passordet"><!--innData Passord-->
                
            </section>
            <section id="knapper">
                <button id="submit_knapp" type="submit" name="submit" value="login">Lagre</button><!--Logg inn button-->
                <?php if (isset($error)){ ?>
                    <input class="innData" id="feilMelding" type="text" value=" <?php echo "* ".$error; ?>" readonly>
                <?php } ?>
                <?php if (isset($melding)){ ?>
                    <input class="innData" id="melding" type="text" value=" <?php echo "* ".$melding; ?>" readonly>
                <?php } ?>
            </section>
        </form>
        <button id="bytte_knapp" type="button" onclick="document.location='byttePassord.php'">Bytte passord</button>
    </article>
  </main>

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>

