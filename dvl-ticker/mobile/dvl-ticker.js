      var liga_akt = "1blf";
      //var pfad_couchdb = "http://localhost:5984/dvl2011/_design/lifeticker/_view/";
      var pfad_couchdb = "http://couchdb.volleyballserver.de/dvl2011/_design/lifeticker/_view/";
      var wochentag = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
     

    
    /** ******************************************************************/
	/* Statusleiste     DAttum Uhrzeit                                  */
	/********************************************************************/
       var jetzt = new Date();
       $(".akt_datum").html(jetzt.getDate()+"."+jetzt.getMonth()+"."+jetzt.getFullYear()  );
       
        $(".last_update").html(" "+jetzt.getHours()+":"+jetzt.getMinutes()+":"+jetzt.getSeconds());

	
	/** ******************************************************************/
	/* Daten mit Ajax Laden                                              */
	/********************************************************************/
	
	var view="tabellen"; 
    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
       
		if (data.rows) {
			//alert('rows');
			for (var idx in data.rows)
		 	{
		          $("#"+data.rows[idx].key).html(data.rows[idx].value);
		    }
		 }
	});
	
	var view="ticker"; 
    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
       //alert('hallo'); 
		var items = [];
		if (data.rows) {
			//alert('rows');
			for (var idx in data.rows)
		 	{
		 	     var id = data.rows[idx].id;
		 	     if (!items[data.rows[idx].id]) items[id]='';
		         items[id] += data.rows[idx].value;
		        
		    }
		
		  	for (var idx in items) {
		  	   
  		 		$("#ticker_article_"+idx).html(items[idx]);   
		  	};
		} 	
		 
	});
 
	
	
	