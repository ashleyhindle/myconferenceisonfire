# TwiML App - required

Configure your TwiML app's `Request URL` to `https://subdomain.fodor.xyz/simple-conference.php` with `HTTP GET` (not `POST`)

# Adding dial-in numbers - optional

If you [buy a number from Twilio](https://www.twilio.com/user/account/voice/phone-numbers) you can use it with your conferencing system

Simply buy the number, and ensure it's linked to the TWiML app above.

# Showing dial-in number - optional

If you have setup a number and wish to show it on the web panel you can do this by editing `config.php` on the server:

* `ssh root@subdomain.fodor.xyz`
* `vim /var/www/myconferenceisonfire/config.php`