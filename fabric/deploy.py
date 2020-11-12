from fabric.api import *

#Host
env.hosts = [
'192.168.56.101'
]
#Port
env.port = '22'
#user
env.user = 'root'

#init status
def init():
    run("yum -y update")
    run("yum  install yum-utils -y")
    run("yum  install git -y")    
    git_clone()
    yum_docker()    
    setting_docker_registry()
    pull_images()
    run_script()
        
#install docker
def yum_docker():
    run("yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo")
    run("yum  install docker-ce docker-ce-cli containerd.io -y")
    run("systemctl start docker")
    run("yum install docker-compose -y")
    run("yum  install python-docker -y")

#setting docker registry
def setting_docker_registry():
    local("scp /etc/docker/daemon.json root@192.168.56.101:/etc/docker/")
    run("chmod 644 /etc/docker/daemon.json")
    run("systemctl restart docker")

#git clone
def git_clone():
    code_dir = '/opt/tuffy_lin'
    with settings(warn_only=True):
        if run("test -d %s" % code_dir).failed:
            run("git clone ssh://git@gitlab.infinity:10022/training/tuffy_lin.git %s" % code_dir)
    with cd(code_dir):
        run("git pull")

#run docker-compose.sh
def run_script():
    with cd('/opt/tuffy_lin/docker'):
        run("sh 1.start-docker-compose.sh")

#pull docker image
def pull_images():
    run("docker pull 192.168.56.105:5000/nginx")

@task
def go():
    init()
