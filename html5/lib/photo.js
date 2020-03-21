/*

Foto-Schieß-Funktion
--------------------

API:

 * modul.supportsRecording
 * modul.isRecording
 * modul.init(canvasSelector)
 * modul.startRecording(callback)
 * modul.stopRecording()
 * modul.getVideo()
 * modul.getCanvas()

modul.isRecording sollte den aktuellen Zustand des Moduls wiederspiegeln

modul.stopRecording() sollte die Canvas-Übertragung und das Video stoppen

Das Canvas-Element sollte so groß wie der ankommende Videostream sein

*/

define(['lib/vendor/jquery'], function($){

  'use strict';

  var video, context, canvas;

  return {

    // Gibt an, ob Aufnehmen von diesem Browser unterstützt wird
    supportsRecording: (
      typeof navigator.getUserMedia !== 'undefined' &&
      typeof window.URL !== 'undefined' &&
      typeof window.URL.createObjectURL !== 'undefined'
    ),

    // Gibt an, ob gerade aufgenommen wird oder nicht
    isRecording: false,

    // Initialisierung; Variablen `canvas` und `context` belegen,
    // Video-Element `video` erzeugen
    init: function(selector){
      canvas = $(selector)[0];
      context = canvas.getContext('2d');
      video = $('<video>')[0];
    },

    // Startet die Aufnahme
    startRecording: function(callback){
      var self = this;
      navigator.getUserMedia({ video: true, audio: false }, function(stream){
        self.playStream(stream, callback);
      }, function(err){
        window.alert('Fehler ' + err.code);
        console.log(err);
      });
    },

    // Beginnt den Stream abzuspielen. Sobald das Video läuft, wird der Callback
    // ausgeführt
    playStream: function(stream, callback){
      video.src = window.URL.createObjectURL(stream);
      this.isRecording = true;
      $(video).on('play', function(){
        this.resizeCanvas();
        this.copyVideo();
        callback();
      }.bind(this));
      video.play();
    },

    // Passt die Canvas-Größe auf die Größe des Video-Elements an
    resizeCanvas: function(){
      $(canvas).attr({
        width: video.videoWidth,
        height: video.videoHeight
      });
    },

    // Überträgt Video-Daten vom Video-Element auf das Canvas-Element. Der
    // Timeout ist ein Hack für einen Bug im Firefox ~21
    copyVideo: function(){
      var self = this;
      setTimeout(function(){
        self.resizeCanvas(); // Nochmal für den Firefox...
        window.requestAnimationFrame(function render(){
          if(self.isRecording){
            context.drawImage(video, 0, 0);
            window.requestAnimationFrame(render);
          }
        });
      }, 1000);
    },

    // Stoppt die Übertragung von Video-Daten auf das Canvas-Element
    stopRecording: function(){
      this.isRecording = false;
      video.pause();
    },

    // Getter für Video- und Canvas-Elemente
    getVideo: function(){ return video; },
    getCanvas: function(){ return canvas; }

  };

});