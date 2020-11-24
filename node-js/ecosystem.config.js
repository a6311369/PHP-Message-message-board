module.exports = {
  apps : [{
    script: '/opt/gitalb_jenkins_lab/index.js',
    //script: './service-worker/',
    watch: ['/opt/gitalb_jenkins_laba/index.js'],
    exec_mode: 'cluster',
    instances: 2
  }],

  deploy : {
    production : {
      user : 'SSH_USERNAME',
      host : 'SSH_HOSTMACHINE',
      ref  : 'origin/master',
      repo : 'GIT_REPOSITORY',
      path : 'DESTINATION_PATH',
      'pre-deploy-local': '',
      'post-deploy' : 'npm install && pm2 reload ecosystem.config.js --env production',
      'pre-setup': ''
    }
  }
};
