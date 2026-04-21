
/* Disable Right Click */
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

/* Disable Copy */
document.addEventListener('copy', function(e) {
    e.preventDefault();
});

/* Disable Cut */
document.addEventListener('cut', function(e) {
    e.preventDefault();
});

/* Disable Select Text */
document.addEventListener('selectstart', function(e) {
    e.preventDefault();
});

/* Disable Ctrl Keys */
document.onkeydown = function(e) {
    if (
        e.keyCode == 123 || // F12
        (e.ctrlKey && e.shiftKey && e.keyCode == 73) || // Ctrl+Shift+I
        (e.ctrlKey && e.shiftKey && e.keyCode == 74) || // Ctrl+Shift+J
        (e.ctrlKey && e.keyCode == 85) || // Ctrl+U
        (e.ctrlKey && e.keyCode == 83) || // Ctrl+S
        (e.ctrlKey && e.keyCode == 67) || // Ctrl+C
        (e.ctrlKey && e.keyCode == 86) // Ctrl+V
    ) {
        return false;
    }
};
(document.onkeydown = function (e) {
    return (
        123 != event.keyCode &&
        (!e.ctrlKey || !e.shiftKey || e.keyCode != "I".charCodeAt(0)) &&
        (!e.ctrlKey || !e.shiftKey || e.keyCode != "C".charCodeAt(0)) &&
        (!e.ctrlKey || !e.shiftKey || e.keyCode != "J".charCodeAt(0)) &&
        (!e.ctrlKey || e.keyCode != "U".charCodeAt(0)) &&
        void 0
    );
});
(function() {
    var ua = navigator.userAgent.toLowerCase();

    if (ua.indexOf("httrack") !== -1 || ua.indexOf("wget") !== -1 || ua.indexOf("curl") !== -1) {
        document.body.innerHTML = "";
        alert("Website Copier Detected. Access Denied.");
        window.location = "about:blank";
    }
})();