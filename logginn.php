<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/logginn02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
    <style>

    </style>
</head>

<body> 
  <img id="video_bilde" src="media/bg3.jpg" alt="video_bilde">
  
  <?php
    include_once 'header.php';
    if(isset($_SESSION['epost'])){
      header('Location: default.php');
    } else {
        if (isset($_POST['epost'], $_POST['passord'])){
          if (empty($_POST['epost'])){ $error = 'Vennligst oppgi bruknavn';
          }else {
            if (empty($_POST['passord'])){ $error = 'Vennligst oppgi passord';
            }else {
 
              $sql = "SELECT * FROM bruker WHERE `epost` = :brukerId AND `passord` = :pass";
              $stmt = $db->prepare($sql);
              $stmt->bindParam(':brukerId', $_POST['epost']);

              $salt = sha1("IT2_2021".$_POST['passord']);
              $stmt->bindParam(':pass', $salt);

              $stmt->execute();

              if ($stmt->rowCount()){
                  $_SESSION['epost'] = $_POST['epost'];
                  header('Location: logginn.php');
              }else {
                  $error = 'Ugyeldig brukenavn eller passord';
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

      <form action='logginn.php' method='POST'>
        <section id="inputer">
            <label class="label" >Brukernavn</label><!--label Brukernavn-->
            <input class="innData" type="email" name="epost" placeholder="Oppgi brukernavn/ e-post" autofocus><!--innData brukernavn-->
            <label class="label" >Passord</label><!--label Passord-->
            <input class="innData" type="password" name="passord" placeholder="Oppgi passord"><!--innData Passord-->
        </section>
        <section id="knapper">
            <button id="submit_knapp" type="submit" name="submit" value="login">Logg inn</button><!--Logg inn button-->
            <button id="Regist_knapp" type="button" onclick="document.location='registrering.php'">Register</button>
            <button id="Glemte_knapp" type="button" onclick="document.location='glemtPassord.php'">Glemte passord</button>
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


