
<!-- Utviklet av Houssam, Hatim, Jamal, Walid 28.10.20 -->
<!-- Updatert av Houssam, Hatim, Jamal, Walid 06.11.20 -->
<!-- Updatert av Houssam, Hatim, Jamal, Walid 11.11.20 -->

<!-- Updatert av Hatim, Houssam, Jamal, Walid 19.11.20 -->
<!-- Updatert av Houssam, Hatim, Walid 07.12.20 -->
<!-- Updatert av Jamal, Hatim, Walid 09.12.20 -->
<?php
session_start();
include("php-include/db_pdo.php");

    if(isset($_SESSION['epost'])){
        
        $sql = "SELECT * FROM bruker WHERE epost = :brukerId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':brukerId', $_SESSION['epost']);
        $stmt->execute();
    
        
        foreach ($stmt->fetchAll() as $row) {
            $brukerId = $_SESSION['epost'];
            $regPass = $row['passord'];
            $fornavn = $row['fnavn'];
            $etternavn = $row['enavn'];
            $brukertype = $row['brukertype'];
            $stemme = $row['stemme'];
            $fodselsdato = $row['fdato'];
            $kjonen = $row['mann'];
        }

        $kandidat = "nei";
        $sql = "SELECT * FROM kandidat WHERE bruker = :brukerId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':brukerId', $brukerId);
        $stmt->execute();
        if ($stmt->rowCount()){
            $kandidat = "ja";
        
            foreach ($stmt->fetchAll() as $row) {
                $fakultet = $row['fakultet'];
                $institutt = $row['institutt']; 
                $informasjon = $row['informasjon']; 
                $bildeID = $row['bilde'];
                $trukketUtt = $row['trukket'];
            }


            $sql = "SELECT * FROM bilde WHERE idbilde = :bilde";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':bilde', $bildeID);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $row) {
                $bilde = $row['tekst'];
            }
        }
    }
    $sql = "SELECT * FROM valg WHERE idvalg=1";
    
    foreach ($db->query($sql) as $row) {
        $startforslag = $row['startforslag'];
        $sluttforslag = $row['sluttforslag'];
        $startvalg  = $row['startvalg'];
        $sluttvalg = $row['sluttvalg'];
        $kontrollert = $row['kontrollert'];
        $tittel = $row['tittel'];
        $intStartforslag=strtotime($startforslag);
        $intSluttforslag=strtotime($sluttforslag);
        $intStartvalg=strtotime($startvalg);
        $intSluttvalg=strtotime($sluttvalg);
        $intKontrollert=strtotime($kontrollert);
    }

    $idag=date("Y-m-d H:i:s");


    $file = fopen("katalog\\file.html","r");
        $inholde= fgets($file);
    fclose($file);
?>



<header>

      <article id="logo_container">

      
          <!--left-->
          <i id="logo"></i>
          <p id="logoText">AlphaZero<br>R-06</p>
      </article>
  
      <article id="userinfo_container">
          <!--senter-->
            <?php if(isset($_SESSION['epost'])){ 
                if ($fornavn != ""){ ?>
                    <li id="userinfo"><a href="profil.php"><?php echo $fornavn."s"?> profil</a></li>
                <?php }else{ ?>
                    <li id="userinfo"><a href="profil.php"><?php echo $_SESSION['epost']."s"?> profil</a></li>
                <?php }} ?>


      </article>
          
        <article id="icone_container">
          <!--right-->
          <nav>
                
                    <?php if(isset($_SESSION['epost'])){?>
                        <ul id="navBarUl" class="hidden"><!--Navigasjonsbar-->
                        <?php if (date("Y-m-d H:i:s", $intStartforslag) <= $idag && date("Y-m-d H:i:s", $intSluttforslag) > $idag){?>
                            <li><a href="nominering.php">Nominering</a></li>
                        <?php } if (date("Y-m-d H:i:s", $intStartvalg) < $idag && date("Y-m-d H:i:s", $intSluttvalg) > $idag){?>
                            <li><a href="avstemming.php">Avstemming</a></li>
                        <?php } if ((date("Y-m-d H:i:s", $intKontrollert) < $idag && $intKontrollert !="") ||  $brukertype == 3 || $brukertype == 2){?>
                            <li><a href="resultatt.php">Resultatt</a></li>
                        <?php } ?>
                        
                        <?php  if ($brukertype == 2){ ?>
                            <li><a href="admin.php">Admin</a></li>
                    
                        <?php } if ($brukertype == 3 && date("Y-m-d H:i:s", $intSluttvalg) < $idag) { ?>
                        
                            <li><a href="kontroll.php">kontrollere</a></li>
                        <?php } ?>
                        <li id="loggUt_Li"><a href="php-include/loggut.php">Logg ut</a></li>
                    <?php } else{ ?>
                        <ul style="top: 25px;" id="navBarUl" class="hidden"><!--Navigasjonsbar-->
                            <li id="loggUt_Li"><a href="logginn.php">Logg inn</a></li>
                            <li id="regis"><a href="registrering.php">Registrering</a></li>
                    <?php } ?>
                </ul>
                <i id="hamIcone" onclick="changeIcon()"> <!--hamburger skal ha tre linjer, vi brukte Main tagg til å definere linjer-->
                    <i id="hamlinje1" class="ingen"></i>
                    <i id="hamlinje2" class="ingen"></i>
                    <i id="hamlinje3" class="ingen"></i>
                </i>
 
          </nav>
            
        </article>
        <i id="logollll"><a href="default.php">index</a></i>
      <script src = "javascript/hamburger.js"></script>
    </header>

    