<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/admin02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
    <style>

    </style>
</head>

<body> 
  <img id="video_bilde" src="media/bg5.jpg" alt="video_bilde">
  
  <?php
    include_once 'header.php';
    $updates = "$_SERVER[QUERY_STRING]";
    if(!isset($_SESSION['epost'])){
      header('Location: logginn.php');
    } else {
      if ($brukertype !=2){
        header('Location: default.php');
      }
   
      if(isset($_POST['bruker'])){
        $sql = "UPDATE `valg2021`.`bruker` SET `brukertype` = :t WHERE (`epost` = :bnavn);";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':t', $_POST['t']);
        $stmt->bindParam(':bnavn', $_POST['bruker']);
        $stmt->execute();
        header("refresh: 0"); 
        }
        if(isset($_POST['getTittle'])){


          $StartF = $_POST['StartFA'] .'T'. $_POST['StartFB'].':00';
          $SluttF= $_POST['SluttFA'] .'T'. $_POST['SluttFB'].':00';
          $StartV= $_POST['StartVA'] .'T'. $_POST['StartVB'].':00';
          $SluttV = $_POST['SluttVA'] .'T'. $_POST['SluttVB'].':00';
          $Kontroller = $_POST['KontrollerA'] .'T'. $_POST['KontrollerB'].':00';

          
          if(strtotime($StartF ) > strtotime($SluttF)){
            $error = 'sluttforslag må ikke være før startforslag';
          }else{
            if(strtotime($SluttF) > strtotime($StartV)){
              $error = 'startforslag må ikke være før sluttforslag';
            }else{
              if(strtotime($StartV) > strtotime($SluttV )){
                $error = 'sluttforslag må ikke være før startforslag';
              }else{

                $sql = "UPDATE `valg2021`.`valg` SET `startforslag` = :startforslag, `sluttforslag` = :sluttforslag, `startvalg` = :startvalg, `sluttvalg` = :sluttvalg, `kontrollert` = :kontrollert, `tittel` = :tittel WHERE (`idvalg` = '1');";
                
                $stmt = $db->prepare($sql);

                $stmt->bindParam(':startforslag', $StartF );
                $stmt->bindParam(':sluttforslag', $SluttF);
                $stmt->bindParam(':startvalg', $StartV);
                $stmt->bindParam(':sluttvalg', $SluttV );
                $stmt->bindParam(':kontrollert', $Kontroller );
                $stmt->bindParam(':tittel', $_POST['getTittle']);
                $stmt->execute();
                $melding ='Datoene ble oppdaterte';
                header("refresh: 0; url=nyHTML.php");
              }
            }
          }
        }
      }
  ?>


<main>

    <main id="contener">
      <button id="Admingotil" onclick="Admingotil()">
        Klikk her for utnevne en eksisterende bruker til administrator eller kontrollør
      </button>
    <span id="spana" class="hidden1">
          <form id="serch_form" action='admin.php' method='POST'>
              <input id="serch"  type="text" placeholder="Search.." name="search" autofocus>
              <button id="serch_knapp" type="submit">Søk!</button>
          </form>
          
          <?php if (isset($error) || $updates == "updated"){ ?>
      <article id="tabel_med_feilMelding">
    <?php } else{ ?>
      <article id="tabel">
    <?php } ?>
    
        <table>
            <tr><!--Dette er tabell header-->
                <th>Alle brukere</th>
            </tr>
            <?php

            $sql = "SELECT * FROM brukertype, bruker WHERE idbrukertype = brukertype AND epost LIKE :brukerId ORDER BY epost ASC;";
            $stmt = $db->prepare($sql); 
            $aaa ="%";
            if (isset($_POST['search'])){
              $aaa ="%".$_POST['search']."%";
            }
            $stmt->bindParam(':brukerId', $aaa);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $row) {
              $knapper="";
              $form='<form action="admin.php" method="POST">'.
              '<input type="hidden" name="bruker" value="'.$row['epost'].'">';


              if ($row['idbrukertype']==1){
                $knapper='<p class="p">Bytte til: '.$form.
                '<input type="hidden" name="t" value="2">'.
                '<button class="knapp" type="submit">Admin</button></form>'.
                $form.'<input type="hidden" name="t" value="3">'.
                '<button class="knapp" type="submit">Kontrollør</button>'.
                '</form></p>';
                
              }
              if ($row['idbrukertype']==2){
                $knapper='<p class="p">Bytte til: '.$form.
                '<input type="hidden" name="t" value="1">'.
                '<button class="knapp" type="submit">Bruker</button></form>'.
                $form.'<input type="hidden" name="t" value="3">'.
                '<button class="knapp" type="submit">Kontrollør</button>'.
                '</form></p>';
              }
              if ($row['idbrukertype']==3){

                $knapper='<p class="p">Bytte til: '.$form.
                '<input type="hidden" name="t" value="1">'.
                '<button class="knapp" type="submit">Bruker</button></form>'.
                $form.'<input type="hidden" name="t" value="2">'.
                '<button class="knapp" type="submit">Admin</button>'.
                '</form></p>';
              }
                $brukere = "<tr><td>".$row['epost']." (". $row['type'].")<br>".$knapper.
                "</td></tr>";
                echo($brukere);
            }
            
            $startforslagA = substr($startforslag,0 ,10);
            $startforslagB= substr($startforslag, -8, -3);

            $sluttforslagA = substr($sluttforslag,0 ,10);
            $sluttforslagB= substr($sluttforslag, -8, -3);

            $startvalgA = substr($startvalg,0 ,10);
            $startvalgB= substr($startvalg, -8, -3);

            $sluttvalgA = substr($sluttvalg,0 ,10);
            $sluttvalgB= substr($sluttvalg, -8, -3);

            $kontrollertA = substr($kontrollert,0 ,10);
            $kontrollertB= substr($kontrollert, -8, -3);
   
         
    ?>
   
        </table>
        

        
    </article></span>
    <span id="spanb" class="visible1">
        <?php if (isset($error) || $updates == "updated"){ ?>
            <article id="border_med_feilMelding">
        <?php } else{ ?>
            <article id="border">
        <?php } ?>
        <form action='admin.php' method='POST'>


            <section id="inputer">
            <label class="label" >Start forslag: </label>
            <input class="innDataA" type="date" name="StartFA" value= "<?php echo $startforslagA?>" />
            <input class="innDataB" type="time" name="StartFB" value= "<?php echo $startforslagB ?>" />

            <label class="label" >Slutt forslag: </label>
            <input class="innDataA" type="date" name="SluttFA" value= "<?php echo $sluttforslagA ?>" />
            <input class="innDataB" type="time" name="SluttFB" value= "<?php echo $sluttforslagB ?>" />

            <label class="label" >Start valg: </label>
            <input class="innDataA" type="date" name="StartVA" value= "<?php echo $startvalgA ?>" />
            <input class="innDataB" type="time" name="StartVB" value= "<?php echo $startvalgB ?>" />

            <label class="label" >Slutt valg: </label>
            <input class="innDataA" type="date" name="SluttVA" value= "<?php echo $sluttvalgA ?>" />
            <input class="innDataB" type="time" name="SluttVB" value= "<?php echo $sluttvalgB ?>" />

            <label class="label" >Kontroller: </label>
            <input class="innDataA" type="date" name="KontrollerA" value= "<?php echo $kontrollertA ?>" />
            <input class="innDataB" type="time" name="KontrollerB" value= "<?php echo $kontrollertB ?>" />

            <label class="label" >Tittle: </label>
            <input class="innData" type="text" name="getTittle" value= "<?php echo $tittel; ?>" />


            <?php if (isset($error)){ ?>
                <input class="innData" id="feilMelding" type="text" value=" <?php echo "* ".$error; ?>" readonly />
            <?php } ?>
            <?php if ($updates == "updated"){ ?>
                <input class="innData" id="melding" type="text" value="* Datoene ble oppdaterte" readonly />
            <?php } ?>
            <button id="submit_knapp" type="submit" name="submit" value="login">Legge til</button>
            </section>
      
        </form>
        
    </article>
            </span>

    </main>
    
</main>
<script src = "javascript/admin.js"></script>
  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>


