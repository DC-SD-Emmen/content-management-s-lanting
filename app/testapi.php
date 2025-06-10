<?php

header("Content-Type: application/json");

$plantname = $_GET['plantname'];

$url = 'https://pvz-2-api.vercel.app/api/plants/' . $plantname;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
]);

$data = curl_exec($ch);
curl_close($ch);

echo $data;

?>

