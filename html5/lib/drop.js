/*

Drag & Drop-Modul
-----------------

API: Funktion mit zwei Parametern: Selektor der Drop-Zone und Callback-Funktion

Muss außerdem der Dropzone die Klasse `active` geben und entziehen.

*/

define(function () {

    // -------------------- private variablen -------------------

    var _callback;
    var _ziel;

    // -------------------- private methoden -------------------

    function onDragOver(e) {
        // erlaubt den drop - event für das element
        e.preventDefault();
    }

    function onDrop(e) {
        // blockiert das standardverhalten des browsers (redirekt auf datei)
        e.preventDefault();

        // callbackfunktion aufrufen
        _callback.call(_ziel, e);
        
        removeActiveOnExit();
    }

    function setActiveOnEnter() {
        _ziel.classList.add("active");
    }

    function removeActiveOnExit() {
        _ziel.classList.remove("active");
    }

    // -------------------- öffentliche methoden -------------------

    function drop(selector, callback) {

        _callback = callback;
        
        // element mit selector holen
        _ziel = document.querySelector(selector);

        _ziel.addEventListener('dragover', onDragOver, false);
        _ziel.addEventListener('drop', onDrop, false);
        _ziel.addEventListener('dragenter', setActiveOnEnter, false);
        _ziel.addEventListener('dragleave', removeActiveOnExit, false);
    };

    // öffentliche schnittstelle
    return drop;
});
