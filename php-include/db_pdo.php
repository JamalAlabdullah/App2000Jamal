
<!-- Opperettet av Houssam, Hatim, Jamal, Walid 28.10.20 -->



<?php
  class varPDO extends PDO {
    public function __construct() {
      $drv = 'mysql';
      $hst = 's381.usn.no';
      $sch = 'valg2021';
      $usr = 'usr_valg';
      $pwd = 'pw_valg2021';

      $dns = $drv . ':host=' . $hst . ';dbname=' . $sch;
      parent::__construct($dns,$usr,$pwd);       
    }
  }

  $db = new varPDO();
?>