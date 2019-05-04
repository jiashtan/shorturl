<?php
# update url with its hashcode
$URLToCodeFile = "URLtocode.json";
$codeToURLFile = "codetoURL.json";
$URLToCode = file_get_contents($URLToCodeFile);
$codeToURL = file_get_contents($codeToURLFile);
$URLToCode = json_decode($URLToCode, true);
$codeToURL = json_decode($codeToURL, true);
$url = $_POST["url"];

# if the url is not previously hashed into the databases, then create a new key (hashcode)
# and update the hashcode-url pair in both of the URLtocode and codetoURL database
if (!isset($URLToCode[$url])) {
    $hashcode = getHashCode($URLToCode);
    $codeToURL[$hashcode] = $url;
    $URLToCode[$url] = $hashcode;
    $newJsonString = json_encode($codeToURL);
    file_put_contents($codeToURLFile, $newJsonString);
    $newJsonString = json_encode($URLToCode);
    file_put_contents($URLToCodeFile, $newJsonString);
}
$hashcode = $URLToCode[$url];
echo $_SERVER["HTTP_HOST"]."/".$hashcode;
exit;

# generate a random 5 characters string to be the hashcode for a url
function getHashCode($data) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $n = 5;
    $randomCounts = 0;
    $codeFound = false;
    while (!$codeFound) {
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        if (!isset($data[$randomString])) {
            $codeFound = true;
        }
        $randomCounts++;
        if ($randomCounts > 500000) {
            $n++;
        }
    }
    return $randomString;
}
?>
