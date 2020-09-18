# Posting Log
Biotech Website to view apache logs for downloaded files

[![Build Status](https://www.travis-ci.com/IGBIllinois/posting_log.svg?token=6A3MBozQfRa8weLubuLw&branch=master)](https://www.travis-ci.com/IGBIllinois/posting_log)

## Requirements
* Apache
* PHP
* PHP JSON
* PHP MYSQL

## Installation
* Git clone repository or download a tag release
```
git clone https://github.com/IGB-UIUC/posting_log posting_log
```
* Create mysql database
```
CREATE DATABASE posting_log CHARACTER SET utf8;
```
* Create Mysql user with insert,update,select,delete privileges on the database
```
CREATE USER 'posting_log'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT,INSERT,DELETE,UPDATE ON posting_log.* to 'posting_log'@'localhost';
```
* Import database structure
```
mysql -u root -p posting_log < sql/posting_log.sql
```
* Edit Apache virtual host config file.  Add a custom log.  This formats the log as JSON to make it easier to parse 
```
LogFormat "{ \"time\":\"%t\", \"remoteIP\":\"%a\", \"host\":\"%V\", \"request\":\"%U\", \"query\":\"%q\", \"method\":\"%m\", \"status\":\"%>s\", \"userAgent\":\"%{User-agent}i\", \"referer\":\"%{Referer}i\", \"success\":\"%X\" }" posting
CustomLog /var/log/httpd/posting.example.com.log posting
```
* Add apache config to apache configuration to point ot the html directory
```
Alias /posting_log /var/www/posting_log/html
<Directory /var/www/posting_log/html>
	AllowOverride None
	Require all granted
</Directory>
```
* Copy conf/settings.inc.php.dist to conf/settings.inc.php
```
cp conf/settings.inc.php.dist conf/settings.inc.php
```
* Edit conf/settings.inc.php to have database settings
* Run composer to install depedencies
```
composer install
```
* Create symlink to vendor folder from html folder
```
cd html
ln -s ../vendor vendor
```

