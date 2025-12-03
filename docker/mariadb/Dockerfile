FROM mariadb:10.11

RUN apt-get update \
 && apt-get install --no-install-recommends -y tzdata \
 && apt-get clean \
 && rm -r /var/lib/apt/lists/*

RUN echo "Europe/Moscow" > /etc/timezone && dpkg-reconfigure --frontend noninteractive tzdata

COPY config/my.cnf /etc/mysql/my.cnf

EXPOSE 3306
CMD ["mysqld"]
