/* Rollover */

  function imgHi(name){
    document.images["roll_"+name].src="./images/"+name+"-a.gif";
  }
  function imgLo(name){
    document.images["roll_"+name].src="./images/"+name+".gif";
  }
  function imgPreload(){
    for (i=0; i<document.images.length; i++){
      if (document.images[i].name.substr(0,5)=="roll_"){
        var a = new Image();
        loSrc = document.images[i].src; 
        hiSrc = loSrc.substring(0,loSrc.length-4)+"-a.gif";
        a.src = hiSrc;  
      }
    }
  }
