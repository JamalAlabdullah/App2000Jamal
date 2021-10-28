<?php
include_once 'header.php';

	$fil = fopen('katalog/file.html', "w");

  fwrite($fil, '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">');
  fwrite($fil, '<meta name="viewport" content="width=device-width, initial-scale=1.0">');
  fwrite($fil, '<link href="../css/felles02.css" rel="stylesheet" type="text/css" media="all">');
  fwrite($fil, '<link href="../css/index02.css" rel="stylesheet" type="text/css" media="all">');
  fwrite($fil, '<title>Valg den beste fotball spiller i usn</title><style>#html_knapp{top:400px;}</style></head><body>');
  fwrite($fil, '<img id="video_bilde" src="../media/video_bilde.jpg" alt="video_bilde">');
  fwrite($fil, '<video autoplay loop muted><source src="../media/video.mp4" type="video/mp4">');
  fwrite($fil, '</video><main id="main" class="visible"><article>');
  


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
    if($kontrollert <= $idag){
      $printDato= $printDato. '<h4 id= "aktiv" >Kontrollert:'. $kontrollert .'</h4>';
    }else{
    if($kontrollert > $idag){
      $printDato= $printDato. '<h4 >Kontrollert:'. $kontrollert .'</h4>';
    }else{
      $printDato= $printDato. '<h4 >Kontrollert:<span class="ferdig">'. $kontrollert .'</span></h4>';
    }}


    $printDato= $printDato. '<h4>Tittel: '.$tittel.'</h4></article>';


    $printDato= $printDato. '<article> <button id="html_knapp" type="button" onclick='.'document.location="../default.php"'.' >Tilbake til indeksen</button>';
    $printDato= $printDato. '</article></main><footer><article><p>&copy; Copyright 2020-2021 AlphaZero Gruppe R-06</p></article></footer></body></html>';

  fwrite($fil, $printDato);


  


	fclose($fil);
  header('Location: admin.php?updated');
?>




