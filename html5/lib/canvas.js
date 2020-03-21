/*

Canvas-Library
--------------

API:

 * modul.init(selector)
 * modul.reset()
 * modul.drawUrl(url, callback)

*/

define(['lib/vendor/jquery'], function($) {

  var canvas,
      context,
      image;

  function init (selector) {
    var $canvas = $(selector);
    canvas = $canvas[0];
    context = canvas.getContext('2d');
  }

  function reset () {
    var width,
        height;

    canvasWidth = canvas.width;
    canvasHeight = canvas.height;

    context.clearRect(0, 0, canvasWidth, canvasHeight);
  }

  function el () {
    return canvas;
  }

  function drawUrl (url, done) {
    image = new Image();
    image.src = url;

    image.addEventListener("load", function (event) {
      imageWidth = image.naturalWidth;
      imageHeight = image.naturalHeight;

      canvas.width = imageWidth;
      canvas.height = imageHeight;

      context.drawImage(image, 0, 0);
      done();
    });
  }

  return {
    init: init,
    reset: reset,
    el: el,
    drawUrl: drawUrl
  }

});
