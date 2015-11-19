<?php
$protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
$url = "{$protocol}://{$_SERVER['HTTP_HOST']}";
$url .= str_replace(basename(__FILE__), '',  $_SERVER['PHP_SELF']);

$sounds = [
	'wait' => [ 'local' => 'sounds/wait.wav', 'remote' => "{$url}/sounds/wait.wav" ],
	'joining' => [ 'local' => 'sounds/joining.wav', 'remote' => "{$url}/sounds/joining.wav" ],
	'welcome' => [ 'local' => 'sounds/professional/welcome-mciof.wav', 'remote' => "{$url}/sounds/professional/welcome-mciof.wav" ],
	'enterPin' => [ 'local' => 'sounds/professional/enter-pin.wav', 'remote' => "{$url}/sounds/professional/enter-pin.wav" ],
	'invalidPin' => [ 'local' => 'sounds/professional/invalid-pin.wav', 'remote' => "{$url}/sounds/professional/invalid-pin.wav" ],
];

if (isset($_POST['Digits'])) {
    echo <<<TWIML
    <Response>
	<Play>{$sounds['joining']['remote']}</Play>
        <Dial>
            <Conference waitMethod="GET" waitUrl="{$sounds['wait']['remote']}" beep="true">mciof{$_POST['Digits']}</Conference>
        </Dial>
    </Response>
TWIML;
} else {
    echo <<<TWIML
    <Response>
	<Play>{$sounds['welcome']['remote']}</Play>
        <Gather timeout="10" finishOnKey="#">
		<Play>{$sounds['enterPin']['remote']}</Play>
        </Gather>
	<Play>{$sounds['invalidPin']['remote']}</Play>
</Response>
TWIML;
}
