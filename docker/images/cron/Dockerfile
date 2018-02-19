FROM open-data/site-open-data:latest
MAINTAINER William Hearn <sylus1984@gmail.com>

COPY tasks/ /etc/periodic/
RUN chmod -R +x /etc/periodic/

CMD ["crond", "-f", "-d", "8"]
