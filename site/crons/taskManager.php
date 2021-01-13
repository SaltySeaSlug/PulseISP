<?php

error_reporting(-1); // reports all errors
ini_set("display_errors", "1"); // shows all errors
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");

global $scriptpath;

// LOAD FUNCTIONS
require($scriptpath . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'functions.php');
require $scriptpath . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

function sendMessage($chatID, $messaggio, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

//sendMessage("-1001336638403" , "TEST FROM RADIUS", "943428680:AAERL-nM41fXXDWGYNoTAQ6YG9y2kXxfvmQ");

$bot = new \TelegramBot\Api\BotApi('943428680:AAERL-nM41fXXDWGYNoTAQ6YG9y2kXxfvmQ');

$bot->sendMessage('-1001336638403', 'TEST FROM RADIUS');

echo "Finished";

?>
