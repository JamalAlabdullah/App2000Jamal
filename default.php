<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/felles02.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/index02.css" rel="stylesheet" type="text/css" media="all">
    <title>Valg den beste fotball spiller i usn</title>
</head>

<body> 
  <img id="video_bilde" src="media/video_bilde.jpg" alt="video_bilde">
    <video autoplay loop muted>
        <source src="media/video.mp4" type="video/mp4">
    </video>

    <?php
        include_once 'header.php';
    ?>


  <main id="main" class="visible">
      <article>

        <p id="textTop">Alpha Zero</p>
            <h2>Velkommen til valg av den beste fotballspilleren i USN</h2>
      </article>
      <article>
      <?php
      $printDato="";

        if($startforslag <= $idag && $sluttforslag > $idag){
          $printDato='<h4 id= "aktiv" >Start forslag:'. $startforslag .'</h4>';
        }else{if($startforslag > $idag){
          $printDato='<h4 >Start forslag:'. $startforslag .'</h4>';
        }else{
          $printDato='<h4 >Start forslag:<span class="ferdig">'. $startforslag .'</span></h4>';
        }}
        if($sluttforslag <= $idag && $startvalg > $idag){
          $printDato= $printDato. '<h4 id= "aktiv" >Slutt forslag:'. $sluttforslag .'</h4>';
        }else{
        if($sluttforslag > $idag){
          $printDato= $printDato. '<h4 >Slutt forslag:'. $sluttforslag .'</h4>';
        }else{
          $printDato= $printDato. '<h4 >Slutt forslag:<span class="ferdig">'. $sluttforslag .'</span></h4>';
        }}
        if($startvalg <= $idag && $sluttvalg > $idag){
          $printDato= $printDato. '<h4 id= "aktiv" >Start valg:'. $startvalg .'</h4>';
        }else{
        if($startvalg > $idag){
          $printDato= $printDato. '<h4 >Start valg:'. $startvalg .'</h4>';
        }else{
          $printDato= $printDato. '<h4 >Start valg:<span class="ferdig">'. $startvalg .'</span></h4>';
        }}
        if($sluttvalg <= $idag && $kontrollert > $idag){
          $printDato= $printDato. '<h4 id= "aktiv" >Slutt valg:'. $sluttvalg .'</h4>';
        }else{
        if($sluttvalg > $idag){
          $printDato= $printDato. '<h4 >Slutt valg:'. $sluttvalg .'</h4>';
        }else{
          $printDato= $printDato. '<h4 >Slutt valg:<span class="ferdig">'. $sluttvalg .'</span></h4>';
        }}
        if($kontrollert <= $idag && $kontrollert==!""){
          $printDato= $printDato. '<h4 id= "aktiv" >Kontrollert:'. $kontrollert .'</h4>';
        }else{
        if($kontrollert > $idag){
          $printDato= $printDato. '<h4 >Kontrollert:'. $kontrollert .'</h4>';
        }else{
          $printDato= $printDato. '<h4 >Kontrollert:<span class="ferdig">'. $kontrollert .'</span></h4>';
        }}

      echo $printDato;
    
      ?>



      
        <h4>Tittel: <?php echo $tittel ?></h4>
         
      </article>

      <article>
        <button id="html_knapp" type="button" onclick="document.location='katalog/file.html'">Vis datoene som html</button>
      </article>
  </main>

  <footer>
      <article>
        <p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p>
      </article>
  </footer>

</body>
</html>

