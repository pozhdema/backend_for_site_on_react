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
sudo cp /home/vagrant/php_elementary_course/provision/nginx.conf /etc/nginx/sites-available/site.conf
sudo chmod 644 /etc/nginx/sites-available/site.conf
sudo ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
sudo service nginx restart
echo "-= Nginx configurated =-"

# Copy project files
sudo rm -Rf /var/www/*
echo "-= Folder /var/www cleaned =-"

sudo ln -s /home/vagrant/* /var/www
echo "-= Symlink for /var/www => /home/vagrant created =-"

#mysql-server
export DEBIAN_FRONTEND=noninteractive
sudo -E apt-get -q -y install mysql-server
sudo mysqladmin -u root password $dbPwd
echo "user for MySQL created"

sudo mysql -uroot -p$dbPwd -e "CREATE DATABASE $dbName DEFAULT CHARACTER SET utf8 ;"
sudo mysql -uroot -p$dbPwd -e "CREATE USER $dbUser@localhost IDENTIFIED BY '$dbPwd';"
sudo mysql -uroot -p$dbPwd -e "GRANT ALL PRIVILEGES ON $dbName.* TO '$dbUser'@'localhost';"
sudo mysql -uroot -p$dbPwd -e "FLUSH PRIVILEGES;"
echo "-= Table created =-"
echo "-= Mysql-server installed =-"

sudo mysql -u $dbUser -p$dbPwd $dbName < /home/vagrant/php_elementary_course/provision/dump.sql

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.2
sudo apt-get install -y php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml 
sudo apt-get install -y php7.2-readline php7.2-soap php7.2-xsl php7.2-zip php7.2-intl php7.2-fpm
sudo apt-get install -y php-xdebug
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
php composer-setup.php --install-dir=/usr/local/bin --filename=composer\
    && composer clear-cache \
    && apt-get clean
echo "-= PHP installed =-"

sudo apt-get autoremove -y
sudo service nginx start
echo "-= FINISHED =-"