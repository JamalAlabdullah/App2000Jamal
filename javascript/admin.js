

  function Admingotil() {
    var s1 = document.getElementById("spana");
    var s2 = document.getElementById("spanb");
    var s3 = document.getElementById("Admingotil");
    
    
    if (s1.className === "hidden1") {
      s1.className = "visible1";
      s2.className = "hidden1";
      s3.innerHTML = "Klikk her for registrere eller endre all informasjon om valget";
      

    } else {
      s1.className = "hidden1";
      s2.className = "visible1";
      s3.innerHTML = "Klikk her for utnevne en eksisterende bruker til administrator eller kontrollør";
   
    }
  }
  