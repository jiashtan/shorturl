<?php

    # this program reads the codetoURL json file to find the real URL according
    # to the hashcode. Then redirects the http request to the real URL location

    $myFile = "codetoURL.json";
    $data = file_get_contents($myFile);
    $data = json_decode($data, true);
    $hashcode = $_SERVER["REQUEST_URI"];
    $hashcode = substr($hashcode, 1);
    $url = $data[$hashcode];
    $url = addhttp($url);
    header('Location: '.$url);
    exit;

    # add http in front of the URL
    function addhttp($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }
?>
