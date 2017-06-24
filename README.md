# My Conference Is On Fire

Basic conferencing system built on Twilio, with softphone, phone dial in and professional recordings

## Setup my own system

Deploy your own instance of this app on DigitalOcean in 60~ seconds with Fodor:

[![deploy-with-fodor-image](https://fodor.xyz/images/install-shield.svg)](https://fodor.xyz/provision/ashleyhindle/myconferenceisonfire)

Please make sure you add a [TWiML app](https://www.twilio.com/user/account/voice/dev-tools/twiml-apps) first 

## Test it out
* Go to [https://conference.ashleyhindle.com](https://conference.ashleyhindle.com)
* Call +441315101552
* * or 
* Call (858) 707-7749

Ask your friend to join with the same code!

## How to dial in

* Call your Twilio Number
* Go to your website and use the Twilio javascript client

## Setup

* Add a [TwiML app](https://www.twilio.com/user/account/voice/dev-tools/twiml-apps) to your Twilio account and set the Voice URL to `http://mydomain.com/myconferenceisonfire/simple-conference.php` and `HTTP GET`
* [Buy a number](https://www.twilio.com/user/account/voice/phone-numbers) from Twilio and set it to use your new TwiML app.
* Call your new number, and enter any number and ask other people to enter the same number

![image](twiml-app.png)  

## Browser Connection Setup
* Grab the app's `Sid` from your [TwiML app](https://www.twilio.com/user/account/voice/dev-tools/twiml-apps) configuration
* Grab your `authToken` and `accountSid` from your [account settings](https://www.twilio.com/user/account/settings) page

* Copy `config.php.dist` to `config.php` and set the details
* `composer install`
* Go to `http://mydomain.com/myconferenceisonfire/` and press the big green button


## Nginx Note
I had to add `audio/x-wav             wav;` to `/etc/nginx/mime.types` for Twilio to like my files


## My Thanks
Big thanks to @virelli / http://codepen.io/virelli/pen/mnhgd for the lovely looking dialpad and https://soundcloud.com/alexcornell/im-on-hold-by-alex-cornell for the amazing music
