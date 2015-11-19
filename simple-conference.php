<?php
$protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
$url = "{$protocol}://{$_SERVER['HTTP_HOST']}";
$url .= str_replace(basename(__FILE__), '',  $_SERVER['PHP_SELF']);

$waitUrl = (file_exists('sounds/wait.mp3')) ? $url . 'wait.mp3' : 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient';
$joiningAction = (file_exists('sounds/joining.wav')) ? "<Play>{$url}/sounds/joining.wav</Play>" : '<Say>Joining the conference now</Say>';
$enterPinAction = (file_exists('sounds/enter-pin.wav')) ? "<Play>{$url}/sounds/enter-pin.wav</Play>" : '<Say>Please enter your conference pin number followed by the pound or hash key.</Say>';
$invalidPinAction = (file_exists('sounds/invalid-pin.wav')) ? "<Play>{$url}/sounds/invalid-pin.wav</Play>" : '<Say>Joining the conference now</Say>';

if (isset($_POST['Digits'])) {
    echo <<<TWIML
    <Response>
	{$joiningAction}
        <Dial>
            <Conference waitMethod="GET" waitUrl="{$waitUrl}" beep="true">mciof{$_POST['Digits']}</Conference>
        </Dial>
    </Response>
TWIML;
} else {
    echo <<<TWIML
    <Response>
        <Gather timeout="10" finishOnKey="#">
		{$enterPinAction}
        </Gather>
	{$invalidPinAction}
</Response>
TWIML;
}
