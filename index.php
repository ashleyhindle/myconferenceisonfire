<?php
// Borrowed and modified from https://www.twilio.com/docs/tutorials/twilio-client-browser-soft-phone and https://www.twilio.com/docs/tutorials/twilio-client-browser-conference-call and http://codepen.io/virelli/pen/mnhgd
require_once 'vendor/autoload.php';
$tokens = require_once 'config.php';

$token = new Services_Twilio_Capability($tokens['accountSid'], $tokens['authToken']);
$token->allowClientOutgoing($tokens['appSid']);

$deviceToken = $token->generateToken();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>
			MyConferenceIsOnFire
		</title>
		<link href='http://fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link href="app.css" rel="stylesheet">

		<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

		<script type="text/javascript" src="app.js"></script>
	</head>
	<body>
		<input type="hidden" id="deviceToken" value="<?= $deviceToken ?>">
		<div align="center">
			<div id="status">
				Hold on...
			</div>

			<div id="wrapper">    
				<div class="key" rel="1">1</div>
				<div class="key" rel="2">2<span>abc</span></div>
				<div class="key" rel="3">3<span>def</span></div>
				<div class="clear"></div>
				<div class="key" rel="4">4<span>ghi</span></div>
				<div class="key" rel="5">5<span>jkl</span></div>
				<div class="key" rel="6">6<span>mno</span></div>
				<div class="clear"></div>
				<div class="key" rel="7">7<span>pqrs</span></div>
				<div class="key" rel="8">8<span>tuv</span></div>
				<div class="key" rel="9">9<span>wxyz</span></div>
				<div class="clear"></div>
				<div class="key special" rel="*">*</div>
				<div class="key" rel="1">0<span>oper</span></div>
				<div class="key special" rel="#">#</div>
				<div class="clear"></div>
				<div class="key nb"></div>
				<div class="key phone" rel="connect" style="display: none"><i class="fa fa-phone"></i></div>
				<div class="key nb"></div>
				<div class="clear"></div>
			</div>
		</div>

	</body>
</html>
