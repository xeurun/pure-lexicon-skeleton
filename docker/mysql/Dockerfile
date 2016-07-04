FROM mysql:5.6

ADD mysql-custom.cnf /etc/mysql/conf.d/mysql-custom.cnf
ADD init.sh /init.sh

RUN chmod +x /init.sh
RUN /init.sh
