FROM centos:centos7.8.2003

MAINTAINER Tuffy

WORKDIR /opt/gitalb_jenkins_lab/

COPY config ./config
COPY dockerfile ./dockerfile
COPY index.js .
COPY package.json .
COPY package-lock.json .

RUN yum install epel-release -y
RUN yum install nodejs supervisor -y \
  && mkdir -p /var/log/supervisor
RUN cp dockerfile/start-service.ini /etc/supervisord.d/
RUN npm install -g n && n latest
RUN echo "export N_PREFIX=/usr/local" >> .bash_profile \
  && echo "export PATH=$N_PREFIX/bin:$PATH" >> .bash_profile \
  && source ~/.bash_profile
RUN npm install && npm install pm2 -g


CMD ["/usr/bin/supervisord"]

