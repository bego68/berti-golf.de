    
	var liga_akt = "1blf";
      //var pfad_couchdb = "http://localhost:5984/dvl2011/_design/lifeticker/_view/";
      var pfad_couchdb = "http://couchdb.volleyballserver.de/dvl2011/_design/lifeticker/_view/";
      var wochentag = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
     
     /** ******************************************************************/
	/* Navigation                                                       */
	/********************************************************************/ 
      
      
    $("#nav_1blf").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_1blf").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_1blf").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="1blf";
        
    });

    $("#nav_1blm").click(function () { 
        
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_1blm").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_1blm").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="1blm";
    });

    $("#nav_2blsf").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_2blsf").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_2blsf").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="2blsf";
        
    });

    $("#nav_2blnf").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_2blnf").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_2blnf").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="2blnf";
        
    });

    $("#nav_2blsm").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_2blsm").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_2blsm").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="2blsm";
        
    });

    $("#nav_2blnm").click(function () { 
        $(this).addClass("active");
        $(this).versteckeAlle();
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_2blnm").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_2blnm").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="2blnm";
        
    });

    $("#nav_dvvf").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_dvvf").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_dvvf").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="dvvf";
        
    });

    $("#nav_dvvm").click(function () { 
        $(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_dvvm").removeClass("versteckt");
        $(this).versteckeAlle();
        $("#ticker_dvvm").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="dvvm";
        
    });

     
    $("#nav_alle").click(function () { 
        //$(this).addClass("active");
        $("#tab_"+liga_akt).addClass("versteckt");
        $("#tab_alle").removeClass("versteckt");
        $("#ticker_1blm").removeClass("versteckt");
        $("#ticker_1blf").removeClass("versteckt");
        $("#ticker_2blnm").removeClass("versteckt");
        $("#ticker_2blnf").removeClass("versteckt");
        $("#ticker_2blsm").removeClass("versteckt");
        $("#ticker_2blsf").removeClass("versteckt");
        if (test) {
        	$("#ticker_ligapf").removeClass("versteckt");
        }
        $(".ticker_heading").show();
        //$("#ticker_"+liga_akt).addClass("versteckt");
        //$("#ticker_ligapf").removeClass("versteckt");
        $("#nav_"+liga_akt).removeClass("active");
        liga_akt ="alle";
        
    });
    
    $.fn.versteckeAlle = function(){
    	  $("#ticker_1blm").addClass("versteckt");
          $("#ticker_1blf").addClass("versteckt");
          $("#ticker_2blnm").addClass("versteckt");
          $("#ticker_2blnf").addClass("versteckt");
          $("#ticker_2blsm").addClass("versteckt");
          $("#ticker_2blsf").addClass("versteckt");
          $("#ticker_dvvm").addClass("versteckt");
          $("#ticker_dvvf").addClass("versteckt");
          
          $("#ticker_ligapf").addClass("versteckt");
          
          $(".ticker_heading").hide();
    	    	
    }
   
	/** ******************************************************************/
	/* Get-Vriablen ermitteln                                              */
	/********************************************************************/
  
    function get_GET_params() {
 	   var GET = new Array();
 	   if(location.search.length > 0) {
 	      var get_param_str = location.search.substring(1, location.search.length);
 	      var get_params = get_param_str.split("&");
 	      for(i = 0; i < get_params.length; i++) {
 	         var key_value = get_params[i].split("=");
 	         if(key_value.length == 2) {
 	            var key = key_value[0];
 	            var value = key_value[1];
 	            GET[key] = value;
 	         }
 	      }
 	   }
 	   return(GET);
 	}
 	 
 	function get_GET_param(key) {
 	   var get_params = get_GET_params();
 	   if(get_params[key])
 	      return(get_params[key]);
 	   else
 	      return false;
 	}
    
    var test = get_GET_param('test');
    
  

	
	/** ******************************************************************/
	/* Daten mit Ajax Laden                                              */
	/********************************************************************/
	
    function DatenVonCouch(){
    	this.tableView;
    	this.tickerView;
    }
    
    DatenVonCouch.prototype.setTableView = function(value)
    {
            this.tableView = value;
    }
    DatenVonCouch.prototype.getTableView = function() {
            return this.tableView;
    } 
    
    DatenVonCouch.prototype.setTickerView = function(value){
            this.tickerView = value;
    }
    DatenVonCouch.prototype.getTickerView = function() {
            return this.tickerView;
    } 
       
    DatenVonCouch.prototype.erstelleTabellen = function(){
	    	var view=this.tableView; 
	        $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	           
	    		if (data.rows) {
	    			//alert('rows');
	    			for (var idx in data.rows)
	    		 	{
	    		          $("#"+data.rows[idx].key).html(data.rows[idx].value);
	    		    }
	    		 }
	    	});
	        this.updateAktualisierungdatum();
    } 
    
	
    DatenVonCouch.prototype.erstelleTicker = function(){
		var view=this.tickerView; 
	    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	       //alert('hallo'); 
			var items = [];
			if (data.rows) {
				//alert('rows');
				for (var idx in data.rows)
			 	{
					 //if(idx='1blm' ) alert('1blm');
			 	     var id = data.rows[idx].id;
			 	     if (!items[data.rows[idx].id]) items[id]='';
			         items[id] += data.rows[idx].value;
			        
			    }
			
			  	for (var idx in items) {
			  	   
	  		 		$("#ticker_article_"+idx).html(items[idx]);   
			  	};
			} 	
			 
		});
	    this.updateAktualisierungdatum();
    } 
	
    /** ******************************************************************/
	/* Statusleiste     DAttum Uhrzeit                                  */
	/********************************************************************/
    DatenVonCouch.prototype.updateAktualisierungdatum = function(){
       var jetzt = new Date();
       var monat = jetzt.getMonth()+1;
       if ( monat<10) monat = "0"+monat;
       
       var tag = jetzt.getDate();
       if (tag < 10) tag ="0"+tag;
       
       var stunde = jetzt.getHours();
       if (jetzt.getHours() < 10) stunde ="0"+stunde;
      
       var minute = jetzt.getMinutes();
       if (minute < 10) minute ="0"+minute;
      
       var sekunde = jetzt.getSeconds();
       if (sekunde < 10) sekunde ="0"+sekunde;
       
       $("#akt_datum").html(" "+wochentag[jetzt.getDay()]+", den "+tag+"."+monat+"."+jetzt.getFullYear()  );
        $("#last_update").html(" "+stunde+":"+minute+":"+sekunde);
    }
    
 var ladeDaten	= new DatenVonCouch();
ladeDaten.setTableView('tabellen');
ladeDaten.setTickerView('ticker');
ladeDaten.erstelleTicker();
ladeDaten.erstelleTabellen();
var tabelleAktiv = window.setInterval("ladeDaten.erstelleTicker()", 30000);
var tickerAktiv = window.setInterval("ladeDaten.erstelleTabellen()", 1500000);








	