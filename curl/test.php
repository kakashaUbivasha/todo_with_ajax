<?php

function getToken($email, $password)
{
 $ch = curl_init('http://127.0.0.1:8000/api/login');
 curl_setopt_array($ch,[
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_POST => true,
     CURLOPT_POSTFIELDS => json_encode([
         'email' => $email,
         'password' => $password
     ]),
     CURLOPT_HTTPHEADER => [
         'Content-Type: application/json'
     ],
 ]);
 $response = curl_exec($ch);
 $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 $curlErr  = curl_error($ch);
 curl_close($ch);
    if ($curlErr) {
        echo "Ошибка: $curlErr\n";
        return;
    }

    if ($httpCode !== 200) {
        echo "HTTP ошибка: $httpCode\nОтвет: $response\n";
        return;
    }
 $token = json_decode($response);
 return $token->token??null;
}
function getTasks($token)
{
    $ch = curl_init('http://127.0.0.1:8000/api/tasks');
    curl_setopt_array($ch,[
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token"
        ]
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);
    if ($curlErr) {
        echo "Ошибка: $curlErr\n";
        return;
    }

    if ($httpCode !== 200) {
        echo "HTTP ошибка: $httpCode\nОтвет: $response\n";
        return;
    }
    echo "Задачи: $response\n";
}
function createTask($token, $title, $text, $tags = [])
{
    $ch = curl_init('http://127.0.0.1:8000/api/tasks');
    $data = [
        'title' => $title,
        'text' => $text,
        'tags' => $tags,
    ];
    curl_setopt_array($ch,[
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ]
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);
    if ($curlErr) {
        echo "Ошибка: $curlErr\n";
        return;
    }

    if ($httpCode !== 200) {
        echo "HTTP ошибка: $httpCode\nОтвет: $response\n";
        return;
    }
    echo "Созданная задача: $response\n";
}
$email = "test@gmail.com";
$password = "11223344";
$token = getToken($email, $password);
if (!$token) {
    exit("Ошибка, неправильные данные");
}
getTasks($token);
createTask($token, 'Что то дадада', 'Какое-то описнаиеие', [6]);
