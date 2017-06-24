#!/bin/bash

apt-get -y install nginx php-fpm letsencrypt ca-certificates curl
curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar
chmod a+x /usr/local/bin/composer


rm /etc/nginx/sites-enabled/default
cp fodor/nginx/vhost.conf /etc/nginx/sites-enabled/default

# LetsEncrypt Certificate
mkdir /var/www/letsencrypt/
letsencrypt certonly -a webroot -w /var/www/letsencrypt -d ${DOMAIN} --agree-tos --email ${ADMIN_EMAIL}

# Ensure nginx config points to correct SSL cert
sed -i -e "s/{{DOMAIN}}/${DOMAIN}/g" /etc/nginx/sites-enabled/default

# Ensure x-wav is supported by nginx so Twilio correctly plays the files
sed -e $'s/^}$/        audio\/x-wav wav;\\\n}/g' /etc/nginx/mime.types

service nginx restart

# Setup LetsEncrypt auto renewals
echo "
0 0 */3 * * root /usr/bin/letsencrypt renew --post-hook \"service nginx restart\" >> /var/log/le-renew.log
" > /etc/cron.d/letsencrypt

chmod 644 /etc/cron.d/letsencrypt


# Unattended updates
echo "APT::Periodic::Update-Package-Lists \"1\";
APT::Periodic::Download-Upgradeable-Packages \"1\";
APT::Periodic::AutocleanInterval \"1\";
APT::Periodic::Unattended-Upgrade \"1\";" > /etc/apt/apt.conf.d/10periodic

echo "Unattended-Upgrade::Allowed-Origins {
    \"${distro_id}:${distro_codename}-security\";
    \"*packages.gitlab.com/gitlab/gitlab-ce:${distro_codename}\";
};
Unattended-Upgrade::Package-Blacklist {
    //
};
Unattended-Upgrade::Mail \"root@localhost\";
" >  /etc/apt/apt.conf.d/50unattended-upgrades

ufw allow OpenSSH
ufw allow http
ufw allow https
yes | ufw enable


# ------------

cd ${INSTALLPATH}
cp config.php.dist config.php
sed -i -e "s/{{ACCOUNTSID}}/${ACCOUNTSID}/g" config.php
sed -i -e "s/{{AUTHTOKEN}}/${AUTHTOKEN}/g" config.php
sed -i -e "s/{{APPSID}}/${APPSID}/g" config.php

composer install