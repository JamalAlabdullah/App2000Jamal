//Ble utviklet Av Houssam Melli 11.10.20
//Ble kontrolert av Jamal Al Abdullah den 12.10.20
//Oppdatert av Houssam Melli 15.10.20



//Hamburger menys funksjon skall bytte classen på humburger icon linje, samtidig skal bytte classen til navigasjonsbar
//Skal gjemme/vise navigasjonsbar eller



function changeIcon() {
    var l1 = document.getElementById("hamlinje1");
    var l2 = document.getElementById("hamlinje2");
    var l3 = document.getElementById("hamlinje3");
    var ulVisibilit = document.getElementById("navBarUl");
    
    
    if (l1.className === "ingen") {
      l1.className = "linje1";
      l2.className = "linje2";
      l3.className = "linje3";
      ulVisibilit.className = "visible";

      
    } else {
      l1.className = "ingen";
      l2.className = "ingen";
      l3.className = "ingen";
      ulVisibilit.className = "hidden";
   
    }
  }