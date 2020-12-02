FROM node:15.3-alpine

MAINTAINER Tuffy

WORKDIR /opt/gitalb_jenkins_lab/

COPY . .

RUN apk update && apk add supervisor
RUN mkdir -p /var/log/supervisor && mkdir -p /etc/supervisor.d
RUN cp dockerfile/start-service.ini /etc/supervisor.d
RUN npm install pm2 -g


CMD ["/usr/bin/supervisord"]

