<?php
$config = require_once 'config.php';

$sounds = $config['sounds'];

// This is my horrible voice at the minute, so only play it when we have a good one
$joiningAction = (file_exists($sounds['joining']['local'])) ? "<Play>{$sounds['joining']['remote']}</Play>" : '';
$conferenceCode = false;
if (isset($_POST['Digits'])) {
	$conferenceCode = $_POST['Digits'];
} elseif(isset($_GET['conferenceCode'])) {
	$conferenceCode = $_GET['conferenceCode'];
}

if ($conferenceCode !== false) {
    echo <<<TWIML
    <Response>
	{$joiningAction}
        <Dial>
            <Conference waitMethod="GET" waitUrl="{$sounds['wait']['remote']}" beep="true">mciof{$conferenceCode}</Conference>
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
