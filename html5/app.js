require([
    'lib/vendor/jquery',
    'lib/drop',
    'lib/read',
    'lib/canvas',
    'lib/photo',
    'lib/vendor/filtr'
  ],
  function($, drop, read, canvas, photo, filtr){
	'use strict';	
	
	var filter = filtr('#Dropzone')
    // Hier geht's später weiter
	function enableControls(){
		$('[type=number],#Save, #Delete').attr('disabled',false);
		
	}
	
	function disableControls(){
		$('[type=number],#Save, #Delete').attr('disabled',true);
		$('[type=number]').val(function(){
			return $(this).data('default');
		});
	};
		
		
		canvas.init('#Dropzone');
		
		drop('#Dropzone', function(evt){
			if (evt.dataTransfer.files){
				var file= evt.dataTransfer.files[0];
			};
			
			read.asDataUrl( file, function(content){
				canvas.drawUrl(content, function(){
					enableControls();
					filter.updateSource();
				});
			});
			
		});
		
		$('#Delete').click(function(){
			if(!this.disabled){
				canvas.reset();
				disableControls();
			}
		});
		
		$('#Save').click(function(){
			if(!this.disabled){
				var url = $("canvas")[0].toDataURL();
				location.href = url;
			}
		});
		
		$('[type=number]').on('change keyup', function(){
			var amountContrast = $('#Contrast').val();
			var amountSaturation = $('#Saturation').val();
			var amountSepia = $('#Sepia').val();
			filter
				.revertSource()
				.contrast(amountContrast)
				.saturation(amountSaturation)
				.sepia(amountSepia)
				.render();
			
		});
	
});