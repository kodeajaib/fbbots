<?php
// parameters
$hubVerifyToken = 'testBootIllankFB989879324823423';
$accessToken = "EAADlGz1ZBQZBwBAGVtGjdC7vI7nLQqzgUQmEhicXalofrjoVjjRgbpBNL7QYsDHBNZCpySzj9veZBTvXIJxKI3BJxxvTAw5Lf3qW9HKbUQI9DIvcgVWCFB7SQGmC2uwVrLFtO5ZAZBEi97iPBNZAZC8jtQesxYRPbnitGHsGbSxcWgZDZD";
// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}
// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$answer = "I don't understand. Ask me 'hi'.";
if($messageText == "hi") {
    $answer = "Hello";
}
$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.8/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
