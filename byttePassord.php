<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/registrering02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>

    <style>
        main{
            height: 600px;
        }
        #border, #border_med_feilMelding{
            height: 380px;
            top: 100px;
        }
        #border_med_feilMelding{
            height: 435px;
        }
    </style>

</head>

<body> 
  <img id="video_bilde" src="media/bg1.jpg" alt="video_bilde">
  
 
  <?php

include_once 'header.php';

if(!isset($_SESSION['epost'])){
    header('Location: default.php');
} else {
    if (isset($_POST['epost'], $_POST['passord'])){
       
        if (empty($_POST['epost'])){
            $error = 'logg inn på nytt';
        }else {
            if (empty($_POST['gPassword'])){
                $error = 'Oppgi gamle passord';
            }else {
                if (empty($_POST['passord'])){
                    $error = 'Oppgi ny passord';
                }else {
                    if ($_POST['passord'] != $_POST['passord2']){
                        $error = 'Passordet er ikke likt';

                    }else {
                        if (substr($_POST['epost'],-7) == "@usn.no"){
                            $salt = "IT2_2021";
                            $sql = "SELECT * FROM bruker WHERE `epost` = :brukerId AND `passord` = :pass";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':brukerId', $_POST['epost']);
                            $stmt->bindParam(':pass', sha1($salt.$_POST['gPassword']));

                            $stmt->execute();
                            if ($stmt->rowCount()){

                    
                                $sql = "UPDATE `valg2021`.`bruker` SET `passord` = :pass";
                                $sql.= " WHERE (`epost` = :bnavn);";
                                $stmt = $db->prepare($sql);
                                
                                $stmt->bindParam(':bnavn', $_POST['epost']);
                                $stmt->bindParam(':pass', sha1($salt.$_POST['passord']));
                                $stmt->execute();
                                $melding = 'Passordet ble oppdatert';
                                
                            }else{
                                $error = 'Feil med brukernavn eller passord';
                            }
                        }else{$error = 'Oppgi riktig e-postadresse';}
                    }
                }
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
        <form action='byttePassord.php' method='POST'>
            <section id="inputer">
            <label class="label" >E-postadresse</label>
            <input class="innData" type="email" name="epost" placeholder="Oppgi USN e-postadresse" value= "<?php echo $brukerId ?>" readonly><!--innData brukernavn-->
            <label class="label" >Gamle passord</label>
            <input class="innData" type="password" name="gPassword" placeholder="Oppgi gamle passord" autofocus><!--innData Passord-->
            <label class="label" >Ny passord</label>
            <input class="innData" type="password" name="passord" placeholder="Oppgi passord"><!--innData Passord-->
            <label class="label" >Bekreft ny passord</label>
            <input class="innData" type="password"  name="passord2" placeholder="Bekreft passord">
        </section>
        <section id="knapper">
          <button id="submit_knapp" type="submit" name="submit" value="login">Oppdatere</button><!--Logg inn button-->
          <?php if (isset($error)){ ?>
            <input class="innData" id="feilMelding" type="text" value=" <?php echo "* ".$error; ?>" readonly>
          <?php } ?>
          <?php if (isset($melding)){ ?>
            <input class="innData" id="melding" type="text" value=" <?php echo "* ".$melding; ?>" readonly>
          <?php } ?>
      </section>
      </form> 
    </article>
  </main>

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>

