    
	
      //var pfad_couchdb = "http://localhost:5984/dvl2011/_design/lifeticker/_view/";
      //var pfad_couchdb = "http://couchdb.volleyballserver.de/dvl2011/_design/lifeticker/_view/";
       pfad_couchdb = "http://couchdb.volleyballserver.de/dvl2011_rep/_design/lifeticker/_view/";
      
      var wochentag = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
      /** ******************************************************************/
  	/* Daten mit Ajax Laden                                              */
  	/********************************************************************/
      
      $('div.ui-page').live("swipeleft", function(){
  		var nextpage = $(this).next('div[data-role="page"]');
  		
  		// swipe using id of next page if exists
  		if (nextpage.length > 0) {
  			$.mobile.changePage(nextpage, 'slide');
  		}
  		else{
  			$.mobile.changePage($("#1blm"), 'slide');
  		}
  	});
  	$('div.ui-page').live("swiperight", function(){
  		var prevpage = $(this).prev('div[data-role="page"]');
  		
  		// swipe using id of next page if exists
  		if (prevpage.length > 0) {
  			$.mobile.changePage(prevpage, 'slide', true);
  		}
  		else{
  			$.mobile.changePage($("#2blnm"), 'slide', true);
  		}
  	});


  	
 
	
	/** ******************************************************************/
	/* Daten mit Ajax Laden                                              */
	/********************************************************************/
	
    function DatenVonCouch(){
    	this.tableView;
    	this.tickerView;
    	this.ergebnisView;
    	this.pressView;
    	this.newsView;
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
    DatenVonCouch.prototype.setErgebnisView = function(value){
        this.ergebnisView = value;
	}
	DatenVonCouch.prototype.getTickerView = function() {
	        return this.ergebnisView;
	} 
	
	 DatenVonCouch.prototype.setNewsView = function(value){
         this.newsView = value;
	 }
	 DatenVonCouch.prototype.getNewsView = function() {
	         return this.newsView;
	 } 
	 DatenVonCouch.prototype.setPressView = function(value){
	     this.pressView = value;
	 }
	 DatenVonCouch.prototype.getPressView = function() {
	        return this.pressView;
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
	        
    } 
    
	
    DatenVonCouch.prototype.erstelleTicker = function(){
		var view=this.tickerView; 
	    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	       
			var items = [];
			if (data.rows) {
				
				for (var idx in data.rows)
			 	{
					 //if(idx='1blm' ) alert('1blm');
			 	     var id = data.rows[idx].id;
			 	     if (!items[data.rows[idx].id]) items[id]='';
			         items[id] += data.rows[idx].value;
			    }
			 	for (var idx in items) {
			  		$("#ticker_article_"+idx).html($("#ticker_article_"+idx).html()+items[idx]);   
	  		 		
			  	};
			} 	
			 
		});
	    
    } 
    
    DatenVonCouch.prototype.erstelleErgebnisse = function(){
    	
		var view=this.ergebnisView; 
		
	    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	       
			var items = [];
			if (data.rows) {
				
				for (var idx in data.rows)
			 	{
					 //if(idx='1blm' ) alert('1blm');
			 	     var id = data.rows[idx].id;
			 	     if (!items[data.rows[idx].id]) items[id]='';
			         items[id] += data.rows[idx].value;
			        
			    }
			
			  	for (var idx in items) {
			  	   
	  		 		$("#erg_"+idx).html(items[idx]);   
	  		 		//alert(idx);
			  	};
			} 	
			 
		});
	    
    }
    
    DatenVonCouch.prototype.erstelleNews = function(){
    	
		var view=this.newsView; 
		
	    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	       
			var items = [];
			if (data.rows) {
				
				for (var idx in data.rows)
			 	{
					 //if(idx='1blm' ) alert('1blm');
			 	     var id = data.rows[idx].id;
			 	     if (!items[data.rows[idx].id]) items[id]='';
			         items[id] += data.rows[idx].value;
			        
			    }
			
			  	for (var idx in items) {
			  	   
	  		 		$("#"+idx).prepend(items[idx]);   
	  		 		//alert(idx);
			  	};
			} 	
			 
		});
	    
    }
	  
DatenVonCouch.prototype.erstellePress = function(){
    	
		var view=this.pressView; 
		
	    $.getJSON(pfad_couchdb+view+'?callback=?', null, function(data) { 
	       
			var items = [];
			
			if (data.rows) {
				
				for (var idx in data.rows)
			 	{
					 //if(idx='1blm' ) alert('1blm');
			 	     var id = data.rows[idx].id;
			 	     if (!items[data.rows[idx].id]) items[data.rows[idx].key]='';
			         items[data.rows[idx].key] += data.rows[idx].value;
			         //alert (data.rows[idx].value);
			         
			    }
			
			  	for (var idx in items) {
			  	   
	  		 		$("#"+idx).html(items[idx]);   
	  		 		
			  	};
			} 	
			 
		});
	    
    }

 var ladeDaten	= new DatenVonCouch();
ladeDaten.setTableView('tabellen');
ladeDaten.setTickerView('ticker');
ladeDaten.setErgebnisView('ergebnisse');
ladeDaten.setNewsView('news');
ladeDaten.setPressView('presse');

/* News navigation mit Pfielen */

	
$(".pfeil").live('click',function () { 
	 $('.pfeil_unten').addClass('pfeil');
	 $('.pfeil_unten').removeClass('pfeil_unten');
	 $(this).removeClass('pfeil');
	 $(this).addClass('pfeil_unten');
	 $('.arikel').removeClass('offen');
	 $(this).parent().addClass('offen');
	 $('.arikel').addClass('zu');
	 $(this).parent().removeClass('zu');
	;
    
});

$(".pfeil_unten").live('click',function () { 
	 $(this).removeClass('pfeil_unten');
	 $(this).addClass('pfeil');
	 
	$(this).parent().removeClass('offen');
		
	 $(this).parent().addClass('zu');
	
});

/* Ticker navigation mi Pfielen und Teambuttons */

$(".clearboth").live('click',function () { 
	 $('.ticker_pfeil_unten').addClass('clearboth');
	 $('.clearboth').removeClass('ticker_pfeil_unten');
	 $(this).addClass('ticker_pfeil_unten');
	 $(this).removeClass('clearboth');
	 $('.ticker_spiel').animate({ height:'56px'},400);
	 $(this).parent().parent().animate({ height:'220px'},400);
	 
});

$(".ticker_pfeil_unten").live('click',function () { 
	 $(this).removeClass('ticker_pfeil_unten');
	 $(this).addClass('clearboth');
	 $(this).parent().parent().animate({ height:'56px'},400);
	 $(this).parent().parent().next().addClass('versteckt');
	
});

/* statistik on off */

$(".home_button_off").live('click',function () { 
	 $(this).removeClass('home_button_off');
	 $(this).addClass('home_button_on');
	 $(this).siblings().removeClass('guest_button_on');
	 $(this).siblings().addClass('guest_button_off');
	 
	 
	 $(this).parent().removeClass('beide_off');
	 $(this).parent().removeClass('links_off');
	 $(this).parent().addClass('rechts_off');
	 $(this).parent().parent().parent().next().removeClass('versteckt');
	 $('table.guest').addClass('versteckt');
	 $('table.home').removeClass('versteckt');
	 
});

$(".home_button_on").live('click',function () { 
	 $(this).removeClass('home_button_on');
	 $(this).addClass('home_button_off');
		 
	 $(this).parent().removeClass('rechts_off');
	 $(this).parent().addClass('beide_off');
	 $(this).parent().parent().parent().next().addClass('versteckt');
	 
});

$(".guest_button_off").live('click',function () { 
	 $(this).removeClass('guest_button_off');
	 $(this).addClass('guest_button_on');
	 $(this).siblings().removeClass('home_button_on');
	 $(this).siblings().addClass('home_button_off');
	 
	 
	 $(this).parent().removeClass('beide_off');
	 $(this).parent().removeClass('rechts_off');
	 $(this).parent().addClass('links_off');
	 $(this).parent().parent().parent().next().removeClass('versteckt');
	 $('table.home').addClass('versteckt');
	 $('table.guest').removeClass('versteckt');
});

$(".guest_button_on").live('click',function () { 
	 $(this).removeClass('guest_button_on');
	 $(this).addClass('guest_button_off');
		 
	 $(this).parent().removeClass('links_off');
	 $(this).parent().addClass('beide_off');
	 $(this).parent().parent().parent().next().addClass('versteckt');
});





$("#loading").live('click',function () { 
	$.mobile.changePage('#email', 'fade');
	
});
$('#loading').live('pagecreate',function(event){
	$.mobile.changePage('#email', 'fade');
	
	} );



$(document).ready(function(){
	
	
		 	
	
	 $("#newsletter_form").submit(function() {
	 	   //alert('email');
		  
		  var emaildata ='{"_id":"info@berti2-golf.de","_rev":"1-967a00dff5e02add41819138abb3284d"}';
		  var emailpfad = 'http://localhost:5984/dvl2011_emails';
		  console.log(emailpfad);
		  var jason = $.getJSON(emailpfad, emaildata, function(data) { 
		       
			  alert(status+' - '+data.doc_count);
			 	
		  });
		  jason.succes = function() {
			  alert('jsson: ' + status);
		  };
		  //alert('getjason: '+status);
		  var test=$.ajax({
	            type: "apication/json",
	            datatype: "jsonp",
	            url: emailpfad,
	            data: null,
	            success: function(data)
	            {
			  		alert(status);
	            } 
	            
	        });
		  
		  test.error = function() {
			  alert('ajax: ' + status);
		  };
		 	//alert($("#email").val());
		 	$.mobile.changePage('#email_submit', 'fade');
	    return false;
	 })

});
	