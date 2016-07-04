#!/bin/sh

# Mysql setup
sleep 10 ; \

service mysql start; \

mysql -u root -e "update user set host='%' where user='root';" ; \ 
mysql -u root -e "flush privileges;" ; \   

service mysql stop; \
