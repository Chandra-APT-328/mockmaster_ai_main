<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://grammarbot-neural.p.rapidapi.com/v1/check",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n    \"text\": \"This are some wel-written text.\",\r\n    \"lang\": \"en\"\r\n}",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: grammarbot-neural.p.rapidapi.com",
        "X-RapidAPI-Key: 890f0323abmshea2fd65040ab2b1p1466dejsnda4fbd8131c1",
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}