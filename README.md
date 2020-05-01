##For learn PHP independent of OS need Vagrant + VM.
## Dependencies
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
- [Vagrant](https://www.vagrantup.com/downloads.html) >= 2.2.6
## Local enviroment setup:
Create config file ``config.yaml`` in root of project with next variables:
````
---
  name: php_elementary_cours (VM name)
  hostname: qwe.loc (local hostname)
  path: (path to project in your PC)
  virtualbox:
    memory: 2048(max RAM volume for VM - default 2048)
  ip: 192.168.33.55 (local ip for vagrant listen)
  timezone: Europe/Kiev (server timezone)
  db:
    user: (db user login)
    password: (db useer password)
    name: (db name)
````
add to file by path c:\windows\system32\drivers\etc\hosts
row with data from file config.yaml
````
ip hostname
````
example:
````
192.168.33.55 qwe.loc
#{local ip for vagrant listen } {local hostname} from config.yaml
````

## Description
- OS :
	- Ubuntu 18.04 LTS x64
- DB :
	- MySQL 5.7.xx
- Server (proxy) :
	- Nginx 1.14.x
- Tool :
    - PHP 7.2

## Comand line interface for vagrant
````
- vagrant ssh (logout : CTRL+D)
- vagrant up --provider=virtualbox (start)
- vagrant reload
- vagrant reload --provision
- vagrant halt (stop)
- vagrant suspend
- vagrant destroy (delete VM)
````
- Path to project in local VM
```
cd /var/www/php_elementary_course
```
- Nginx Logs
````
- access_log /var/log/nginx/access.log
- error_log /var/log/nginx/error.log
````