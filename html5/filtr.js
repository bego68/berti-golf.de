(function (root, factory) {
  if (typeof exports === 'object') {
    module.exports = factory();
  } else if (typeof define === 'function' && define.amd) {
    define(factory);
  }
  else {
    root.filtr = factory();
  }
}(this, function () {
  return function filtr (canvas) {

"use strict";

// Accept selectors as initial argument
if(typeof canvas === 'string'){
  canvas = document.querySelector(canvas);
  if(canvas.toString() !== '[object HTMLCanvasElement]'){
    throw new TypeError('Not a canvas element');
  }
}

var ctx = canvas.getContext('2d');

function copyArray(from, to){
  for(var i = 0; i < from.length; i++){
    to[i] = from[i];
  }
}

// Initial source setup
var sourceData, savedSourceDataArray;
function updateSource () {
  sourceData = ctx.getImageData(0, 0, ctx.canvas.width, ctx.canvas.height);
  savedSourceDataArray = new Uint8ClampedArray(sourceData.data.length);
  copyArray(sourceData.data, savedSourceDataArray);
}
updateSource();

return {

  // Re-read source pixels from the canvas element
  updateSource: function () {
    updateSource();
    return this;
  },

  // Revert to the pixel data filtr was initialized with
  revertSource: function () {
    copyArray(savedSourceDataArray, sourceData.data);
    return this;
  },

  saturation: function (amount) {
    amount *= -0.01;
    var max, r, g, b;
    for(var i = 0; i < sourceData.data.length; i += 4){
      r = sourceData.data[i], g = sourceData.data[i + 1], b = sourceData.data[i + 2];
      max = Math.max(r, g, b);
      if (r !== max){
        r += (max - r) * amount;
      }
      if (g !== max){
        g += (max - g) * amount;
      }
      if (b !== max){
        b += (max - b) * amount;
      }
      sourceData.data[i] = r;
      sourceData.data[i + 1] = g;
      sourceData.data[i + 2] = b;
    }
    return this;
  },

  brightness: function (amount) {
    amount = Math.floor(255 * (amount / 100));
    for(var i = 0; i < sourceData.data.length; i += 4){
      sourceData.data[i] = sourceData.data[i] + amount;
      sourceData.data[i + 1] = sourceData.data[i + 1] + amount;
      sourceData.data[i + 2] = sourceData.data[i + 2] + amount;
    }
    return this;
  },

  contrast: function (amount) {
    amount = Number(amount); // strings are toxic here
    amount = Math.pow((amount + 100) / 100, 2);
    var r, g, b;
    for(var i = 0; i < sourceData.data.length; i += 4){
      r = sourceData.data[i], g = sourceData.data[i + 1], b = sourceData.data[i + 2];
      r /= 255;
      r -= 0.5;
      r *= amount;
      r += 0.5;
      r *= 255;
      g /= 255;
      g -= 0.5;
      g *= amount;
      g += 0.5;
      g *= 255;
      b /= 255;
      b -= 0.5;
      b *= amount;
      b += 0.5;
      b *= 255;
      sourceData.data[i] = r;
      sourceData.data[i + 1] = g;
      sourceData.data[i + 2] = b;
    }
    return this;
  },

  sepia: function (amount) {
    if (typeof amount === 'undefined') {
      amount = 100;
    }
    amount /= 100;
    for(var i = 0; i < sourceData.data.length; i += 4){
      var r = sourceData.data[i], g = sourceData.data[i + 1], b = sourceData.data[i + 2];
      sourceData.data[i] = Math.min(255,
        (r * (1 - 0.607 * amount)) + (g * (0.769 * amount)) + (b * (0.189 * amount))
      ),
      sourceData.data[i + 1] = Math.min(255,
        (r * (0.349 * amount)) + (g * (1 - 0.314 * amount)) + (b * (0.168 * amount))
      ),
      sourceData.data[i + 2] = Math.min(255,
        (r * (0.272 * amount)) + (g * (0.534 * amount)) + (b * (1- 0.869 * amount))
      );
    }
    return this;
  },

  render: function () {
    ctx.putImageData(sourceData, 0, 0);
  }

};

  };
}));
