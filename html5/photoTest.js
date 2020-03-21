define(['lib/photo'], function(photo){

  test('API-Vollständigkeit', function(){
    equal(typeof photo, 'object', 'photo-Modul übergibt Objekt');
    equal(typeof photo.supportsRecording, 'boolean', 'photo.supportsRecording ist ein Boolean');
    equal(typeof photo.isRecording, 'boolean', 'photo.isRecording ist ein Boolean');
    equal(typeof photo.init, 'function', 'photo.init ist eine Funktion');
    equal(photo.init.length, 1, 'photo.init akzeptiert einen Parameter');
    equal(typeof photo.startRecording, 'function', 'photo.startRecording ist eine Funktion');
    equal(photo.startRecording.length, 1, 'photo.startRecording akzeptiert einen Parameter');
    equal(typeof photo.stopRecording, 'function', 'photo.stopRecording ist eine Funktion');
    equal(photo.stopRecording.length, 0, 'photo.stopRecording akzeptiert null Parameter');
    equal(typeof photo.getVideo, 'function', 'photo.getVideo ist eine Funktion');
    equal(photo.getVideo.length, 0, 'photo.getVideo akzeptiert null Parameter');
    equal(typeof photo.getCanvas, 'function', 'photo.getCanvas ist eine Funktion');
    equal(photo.getCanvas.length, 0, 'photo.getCanvas akzeptiert null Parameter');
  });

  test('photo.supportsRecording', function(){
    var api = navigator.getUserMedia ||
              navigator.webkitGetUserMedia ||
              navigator.mozGetUserMedia ||
              navigator.msGetUserMedia;
    var supportsTest = (typeof navigator.getUserMedia !== 'undefined');
    equal(photo.supportsRecording, supportsTest, 'photo.supportsRecording gibt Browserunterstützung an');
    equal(photo.supportsRecording, true, 'Browserunterstützung für Tests vorhanden');
  });

  test('Init und Getter', function(){
    photo.init('canvas');
    equal(photo.getCanvas().toString(), '[object HTMLCanvasElement]', 'Canvas wird initialisiert und bereitgestellt');
    equal(photo.getVideo().toString(), '[object HTMLVideoElement]', 'Video wird initialisiert und bereitgestellt');
  });

  test('Aufnahme und Aufnahmestopp', function(){
    stop(2);
    photo.init('canvas');

    photo.startRecording(function(){
      ok(true, 'Callback von photo.startRecording() wird ausgeführt');
      ok(photo.isRecording, 'photo.isRecording ist nach photo.startRecording() true');
      equal(photo.getVideo().videoWidth, photo.getCanvas().width, 'Canvas-Breite === Stream-Breite');
      equal(photo.getVideo().videoHeight, photo.getCanvas().height, 'Canvas-Höhe === Stream-Höhe');
      equal(photo.getVideo().paused, false, 'Video wird nach photo.startRecording() abgespielt');
      start();
      setTimeout(function(){
        photo.stopRecording();
        ok(!photo.isRecording, 'photo.isRecording ist nach photo.stopRecording() false');
        equal(photo.getVideo().paused, true, 'Video ist nach photo.stopRecording() gestoppt');
        start();
      }, 2000);
    });


  });

});