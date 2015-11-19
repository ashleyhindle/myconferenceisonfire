# My Conference Is On Fire

Very basic conferencing system built on Twilio


## Setup

* Add a [TwiML app](https://www.twilio.com/user/account/voice/dev-tools/twiml-apps) to your Twilio account and set the Voice URL to `http://mydomain.com/myconferenceisonfire/simple-conference.php` and `HTTP GET`
* [Buy a number](https://www.twilio.com/user/account/voice/phone-numbers) from Twilio and set it to use your new TwiML app.

![image](twiml-app.png)  


## Nginx Note
I had to add `audio/x-wav             wav;` to `/etc/nginx/mime.types` for Twilio to like my files
