<?php

// Save theses values
$currentDay = date("N");
$currentHour = date("H:i");

// Our file
$file = './twtname.conf'; // Read the README for how to use it!
$fileC = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Read the file and put each lines in an array

$config = array_slice($fileC, 0, 8);
$lines = array_slice($fileC, 8, 999);

foreach($config as &$value){
    $value = substr($value, strpos($value, ':') + 2);
}

if(!empty($_GET['s'])) { // `http://url?s=Value` can change the name and lock to it. Send "reset", "disable" or "enable" to do what it means.
    $get = $_GET['s'];
    if($get == 'reset') {
        $name = $config['2'];
        // Set "lock" to `0`
        $fileC['1'] = 'Lock: 0';
    } elseif($get == 'disable') {
        // Set "Disable" to `1`
        $fileC['0'] = '1';
    } elseif($get == 'enable') {
        $fileC['0'] = 'Disable: 0';
        // Set "Disable" to `0`
        $fileC['0'] = 'Disable: 0';
    } else {
        $name = $get;
        // Set "lock" with $get value
        $fileC['1'] = 'Lock: '. $get;
    }
    $new_content = implode("\n", $fileC);
    file_put_contents($file, $new_content);
} elseif($config['1'] != '0') { // `Lock: Value` (put it at 0 to disable the lock)
    $name = $config['1'];
} else {
    foreach($lines as $line) { // Note: last lines can overwrite the $name value if set before
        $data = explode(", ", $line); // each config values is sperated by a coma and a space 
        if($currentDay == $data['0'] AND $currentHour >= $data['1'] AND $currentHour < $data['2']) {
            $name = $data['3'];
        }
    }
}

if(empty($name)){ // If there's nothing, then use the `Default: ` value.
    $name = $config['2'];
}

if($config['0'] == '1') { // If you set up `Disable: 1` in the config file, then we stop the script.
    die('This script is disabled. Enable it again in the '. $file .' file.');
}

$message = "[currentDay] '". $currentDay ."', ";
$message .= "[currentHour] '". $currentHour ."', ";
$message .= "[name] '". $name ."'";

require_once('./codebird-php/src/codebird.php'); // You will need [codebird.php](https://github.com/jublonet/codebird-php/tree/develop/src)
\Codebird\Codebird::setConsumerKey($config['4'], $config['5']);
$cb = \Codebird\Codebird::getInstance();
//$cb->setToken($config['6'], $config['7']);
$params = array(
  'name' => $name
);

try {
    $update = $cb->account_updateProfile($params);
} catch (Exception $e) {
    $message .= "\r\n**Error**: '" . $e->getMessage() ."'";
    $message .= "\r\n--- Stopping. ---";
    mail($config['3'], 'Error with twtname', $message);
}

echo $message;
