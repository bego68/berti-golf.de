/*

Datei-Einlese-Library
---------------------

API: modul.asDataUrl(file, callback)

Muss dem Callback die eingelesene Datei als Data-URL übergeben

*/

define([ 'lib/vendor/jquery'],function(){ 
	
	return {
		asDataUrl: function(file,callback){
			var meinReader = new FileReader();
			meinReader.readAsDataURL(file);
			
			meinReader.onload = function(){
				callback(this.result);
			//	$('#qunit').append('<img src="' + this.result + '" />');
			} 
		
		}	
		
	};	
		
//	} );
		


});
