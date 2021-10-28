<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/profilKandidat02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>

</head>

<body> 
  <img id="video_bilde" src="media/bg3.jpg" alt="video_bilde">
  
 
<?php
    $bildeNavn = "";
    include_once 'header.php';
    if(!isset($_SESSION['epost'])){
        header('Location: default.php');
    } else {
        $checked="";
        $bildeNavn = "$_SERVER[QUERY_STRING]";

        
        if($kandidat === "nei" || (date("Y-m-d H:i:s", $intStartforslag) > $idag || date("Y-m-d H:i:s", $intSluttforslag) < $idag)){
            header('Location: profil.php');
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
            }if (empty($_POST['fakultet'])){
                $_POST['fakultet']=null;
            }if (empty($_POST['institutt'])){
                $_POST['institutt']=null;                 
            }
            $sql = "UPDATE `valg2021`.`bruker` SET `enavn` = :enavn, `fnavn` = :fnavn, `fdato` = :fdato, `mann` = :mann";
            $sql.= " WHERE (`epost` = :bnavn);";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':enavn', $_POST['etternavn']);
            $stmt->bindParam(':fnavn', $_POST['fornavn']);
            $stmt->bindParam(':fdato', $_POST['fdato']);
            $stmt->bindParam(':mann', $_POST['kjonn']);
            $stmt->bindParam(':bnavn', $brukerId);
            $stmt->execute();


            

            $sql = "UPDATE `valg2021`.`kandidat` SET `fakultet` = :fakultet, `institutt` = :institutt, `informasjon` = :informasjon";
            $sql.= "  WHERE (`bruker` = :bnavn);";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':fakultet', $_POST['fakultet']);
            $stmt->bindParam(':institutt', $_POST['institutt']);
            $stmt->bindParam(':informasjon', $_POST['informasjon']);
            $stmt->bindParam(':bnavn', $brukerId);
            $stmt->execute();
        



            $sql = "UPDATE `valg2021`.`bilde` SET `tekst` = :bildeTekst";
            $sql.= " WHERE (`idbilde` = :bildeID)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':bildeID', $bildeID);
            $stmt->bindParam(':bildeTekst', $_POST['bilde']);

            $stmt->execute();


            $melding = 'Profilen oppdates...';
            
            header("refresh: 1"); 
    

        }
    }
?>




  <main id="main" class="visible">
    <?php if (isset($error) || isset($melding)){ ?>
      <article id="border_med_feilMelding">
    <?php } else{ ?>
      <article id="border">
    <?php } ?>

        <form action='profilKandidat.php' method='POST'>
            <?php if($bilde!=""){ 
                if($bildeNavn==""){?>
                    <img id="bilde" type="image" src="katalog/<?php echo $bilde ?>"  alt="profil bilde: <?php echo $bilde ?>"/>
                <?php }else{ ?>
                    <img id="bilde" type="image" src="katalog/<?php echo $bildeNavn ?>"  alt="profil bilde: <?php echo $bilde ?>"/>
                
                
            <?php }}else{ ?>
                <img id="bilde" type="image" src= "media/defaultA.jpg"  alt="profil bilde: <?php echo $bilde ?>"/>
            <?php }?>
                <img id="editbilde" type="image" src="media/editIcon.png"  alt="profil bilde: <?php echo $bilde ?>"/>

            <section id="inputer">
                <label class="label" >Fornavn</label>
                <input class="innData" type="text" name="fornavn" placeholder="Oppgi Fornavn" value= "<?php echo $fornavn ?>" autofocus>
                <label class="label" >Etternavn</label>
                <input class="innData" type="text" name="etternavn" placeholder="Oppgi Etternavn" value= "<?php echo $etternavn ?>" >

                <label class="label" >Fødselsdato</label>
                <input class="innData" type="date" name="fdato" placeholder="Oppgi fdato"  value= "<?php echo $fodselsdato ?>">
                <label class="label">Kjønn: </label>
                <i class="label knapper">
                    <input type="radio" name="kjonn" value="M" <?php if($kjonen==="M"){$checked = "checked"; echo $checked; } ?>> <!-- Mann -->
                    <label for="Mann">Mann</label>
                    <input type="radio" name="kjonn" value="K" <?php if($kjonen==="K"){$checked = "checked"; echo $checked; } ?>> <!-- Kvinne -->
                    <label for="Kvinne">Kvinne</label>
                    <input type="radio" name="kjonn" value="A" <?php if($kjonen==="A"){$checked = "checked"; echo $checked; } ?>> <!-- Andre -->
                    <label for="Andre">Andre</label>
                </i>
                  

            </section>
            <section id="inputer2">
                    <label class="label" >Fakultet</label><!--label Passord-->
                    <input class="innData" type="text" name="fakultet" value= "<?php echo $fakultet ?>" ><!--innData fakultet-->
            
                    <label class="label" >Institutt</label><!--label Passord-->
                    <input class="innData" type="text" name="institutt" value= "<?php echo $institutt ?>" ><!--innData institutt-->
                    <label class="label" >Om kandidaten</label>
                    <textarea class="innData" id="text" name="informasjon" type="text"><?php echo $informasjon ?></textarea>
                
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
            <input style="visibility:hidden;" type="text" name="bilde" value="<?php if($bildeNavn==""){ echo $bilde; }else{ echo $bildeNavn; } ?>" >
        </form> 

      
        <button id="bytte_knapp" type="button" onclick="document.location='byttePassord.php'">Bytte passord</button>

        <form action='php-include/slettKandidaten.php' method="POST">
        <?php if ($trukketUtt == "j" || $trukketUtt == "J" || $trukketUtt == "1"  || $trukketUtt == "y"  || $trukketUtt == "Y"){ ?>

                <p id="paragraph">Du har trukket deg ut, og andre <br>brukere ikke kan nominere deg lengre<br> du kan legge deg til igjen
                ved å gå til <br>Nominering og trekke deg inn <br>  </p>

        <?php }else{ ?>
        
            <input style="visibility: hidden;" type="text" name="kandidatNavn" value="<?php echo $brukerId ?>" >
            <button id="slette_knapp" type="submit" name="submit">Trekk ut</button>
        <?php } ?>
        </form>



        <form enctype="multipart/form-data" action="php-include/uploadBilde.php?Profil" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <input style="opacity: 0; cursor: pointer;"  id="editbilde_knapp" name="uploadedfile" type="file" onchange="this.form.submit()"/><br />
            <input style="visibility: hidden; " type="submit" value="Last opp Fil" />
            
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

