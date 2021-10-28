<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/registrering02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>

</head>

<body> 
  <img id="video_bilde" src="media/bg2.jpg" alt="video_bilde">
  
 
  <?php

include_once 'header.php';

if(isset($_SESSION['epost'])){
    header('Location: default.php');
} else {
    if (isset($_POST['epost'], $_POST['passord'])){
        if (empty($_POST['fornavn'])){
            $_POST['fornavn']=$_POST['epost'];
        }if (empty($_POST['etternavn'])){
            $_POST['etternavn']=null;
        }if (empty($_POST['kjonn'])){
            $_POST['kjonn']=null; 
        }if (empty($_POST['fdato'])){
            $_POST['fdato']=null; 
        }if (empty($_POST['epost'])){
            $error = 'Oppgi e-post';
        }else {
            if (empty($_POST['passord'])){
                $error = 'Oppgi passord';
            }else {
                if ($_POST['passord'] != $_POST['passord2']){
                    $error = 'Passordet er ikke likt';
                }else {
                    if (substr($_POST['epost'],-7) == "@usn.no"){
                        $sql = "SELECT * FROM bruker WHERE epost = :brukerId";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':brukerId', $_POST['epost']);
                        $stmt->execute();
                        if ($stmt->rowCount()){
                            $error = 'E-postadresse er allerede brukt';
                        }else{


    
                            $sql = "INSERT INTO `valg2021`.`bruker` (`epost`, `passord`, `enavn`, `fnavn`, `brukertype`, `fdato`, `mann`)";
                            $sql.= " VALUES (:bnavn, :pass, :enavn, :fnavn, '1', :fdato, :mann)";
                            $stmt = $db->prepare($sql);
                            $salt = "IT2_2021";
                            $stmt->bindParam(':bnavn', $_POST['epost']);
                            $stmt->bindParam(':pass', sha1($salt.$_POST['passord']));
                            $stmt->bindParam(':enavn', $_POST['etternavn']);
                            $stmt->bindParam(':fnavn', $_POST['fornavn']);
                            $stmt->bindParam(':fdato', $_POST['fdato']);
                            $stmt->bindParam(':mann', $_POST['kjonn']);
                            $stmt->execute();
                            $_SESSION['epost'] = $_POST['epost'];
                            header("Location: default.php");
                        }
                    }else{$error = 'Velg domain ...@usn.no';} 
                }
            }
        }
    }
}
?>

  <main id="main" class="visible">
    <?php if (isset($error)){ ?>
      <article id="border_med_feilMelding">
    <?php } else{ ?>
      <article id="border">
    <?php } ?>

        <form action='registrering.php' method='POST'>
            <section id="inputer">
            <label class="label" >Fornavn</label>
            <input class="innData" type="text" name="fornavn" placeholder="Oppgi Fornavn" autofocus>
            <label class="label" >Etternavn</label>
            <input class="innData" type="text" name="etternavn" placeholder="Oppgi Etternavn">

            <label class="label">Kjønn: </label>
              <i id="i" class="label knapper">
                <input type="radio" name="kjonn" value="M"> <!-- Mann -->
                <label for="Mann">Mann</label>
                <input type="radio" name="kjonn" value="K"> <!-- Kvinne -->
                <label for="Kvinne">Kvinne</label>
                <input type="radio" name="kjonn" value="A"> <!-- Andre -->
                <label for="Andre">Andre</label>
              </i>
              <label class="label" >Fødselsdato</label>
              <input class="innData" type="date" name="fdato" placeholder="dd.mm.åååå">

            <label class="label" >E-postadresse</label>
            <input class="innData" type="email" name="epost" placeholder="Oppgi USN e-postadresse"><!--innData brukernavn-->
            <label class="label" >Passord</label>
            <input class="innData" type="password" name="passord" placeholder="Oppgi passord"><!--innData Passord-->
            <label class="label" >Bekreftelse</label>
            <input class="innData" type="password"  name="passord2" placeholder="Bekreft passord">
        </section>
        <section id="knapper">
          <button id="submit_knapp" type="submit" name="submit" value="login">Registrering</button><!--Logg inn button-->
          <?php if (isset($error)){ ?>
            <input class="innData" id="feilMelding" type="text" value=" <?php echo "* ".$error; ?>" readonly>
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

