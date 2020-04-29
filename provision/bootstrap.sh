#!/bin/bash

timezone=$1
dbUser=$2
dbPwd=$3
dbName=$4

echo "-= Start build =-";
# OS config
sudo timedatectl set-timezone $timezone
echo "-= Timezone seted =-";
sudo apt-get -y update
sudo apt-get -y upgrade
sudo apt-get -y install curl
sudo apt-get -y install git
sudo apt-get -y install wget
sudo apt-get -y install iptables
sudo apt-get -y install debconf-utils
sudo apt-get -y install zip
sudo apt-get -y install unzip
sudo apt-get -y install software-properties-common
echo "-= OS updated =-";

# Nginx install
sudo apt-get -y install nginx
echo "-= Nginx installed =-"

# Nginx setup
sudo cp /home/vagrant/project/provision/nginx.conf /etc/nginx/sites-available/site.conf
sudo chmod 644 /etc/nginx/sites-available/site.conf
sudo ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
sudo service nginx restart
echo "-= Nginx configurated =-"

# Copy project files
sudo rm -Rf /var/www/*
echo "-= Folder /var/www cleaned =-"

sudo ln -s /home/vagrant /var/www
echo "-= Symlink for /var/www => /home/vagrant created =-"

sudo apt-get -y --no-install-recommends install curl ca-certificates unzip \
        php7.2-cli php7.2-curl php-apcu php-apcu-bc \
        php7.2-json php7.2-mbstring php7.2-opcache php7.2-readline php7.2-xml php7.2-zip \
        build-essential make \
        php7.2-dev php-pear \
        php7.2-mysql php-redis php-xdebug php7.2-bcmath php7.2-bz2 php7.2-gd php7.2-intl php-ssh2 php7.2-xsl php-yaml cron php-phpseclib php-seclib \
        php-mbstring php7.2-curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require hirak/prestissimo \
    && composer clear-cache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* ~/.composer
echo "-= PHP installed =-"

#mysql-server
export DEBIAN_FRONTEND=noninteractive
sudo -E apt-get -q -y install mysql-server
mysqladmin -u root password $dbPwd
echo "user for MySQL created"

mysql -uroot -p$dbPwd -e "CREATE DATABASE $dbName DEFAULT CHARACTER SET utf8 ;"
mysql -uroot -p$dbPwd -e "CREATE USER $dbUser@localhost IDENTIFIED BY '$dbPwd';"
mysql -uroot -p$dbPwd -e "GRANT ALL PRIVILEGES ON $dbName.* TO '$dbUser'@'localhost';"
mysql -uroot -p$dbPwd -e "FLUSH PRIVILEGES;"
echo "-= Table created =-"
echo "-= Mysql-server installed =-"

sudo mysql -u $dbUser -p$dbPwd $dbName < /home/vagrant/php_elementary_course/provision/dump.sql
sudo apt-get autoremove -y
sudo service nginx start
echo "-= FINISHED =-"