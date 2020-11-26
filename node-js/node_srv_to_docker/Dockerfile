FROM centos:centos7.8.2003

MAINTAINER Tuffy

WORKDIR /opt/gitalb_jenkins_laba/

COPY ecosystem.config.js ./
COPY index.js ./
COPY package.json ./
COPY package-lock.json ./
COPY start-service.ini ./

RUN yum install epel-release -y
RUN yum install nodejs supervisor -y \
  && mkdir -p /var/log/supervisor \
  && cp start-service.ini /etc/supervisord.d/
RUN npm install -g n && n latest
RUN echo "export N_PREFIX=/usr/local" >> .bash_profile \
  && echo "export PATH=$N_PREFIX/bin:$PATH" >> .bash_profile \
  && source ~/.bash_profile
RUN npm install && npm install pm2 -g

CMD ["/usr/bin/supervisord"]

