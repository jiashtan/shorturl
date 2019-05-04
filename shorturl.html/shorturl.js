(function() {
    "use strict";
    window.addEventListener("load", init);
    function init() {
        let btn = document.getElementById("btn");
        btn.addEventListener("click", shortUrl);
    }

// get the user's input url and
// call the php program that updates the url and hashcode pair to the hashtable database
function shortUrl() {
    let value = document.getElementById("url").value;
    let data = {url: value};
    $.post('/shorturl.php', data, function(response) {
        document.getElementById("texts").value = response;
    });
}
}());