module.exports = {
  apps : [{
    script: './index.js',
    //script: './service-worker/',
    watch: ['./index.js'],
    exec_mode: 'cluster',
    env_production: {
      NODE_ENV: "production",
    },
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
