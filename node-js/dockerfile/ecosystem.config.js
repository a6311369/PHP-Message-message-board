module.exports = {
  apps : [{
    script: '/opt/gitalb_jenkins_lab/index.js',
    watch: ['/opt/gitalb_jenkins_lab/index.js'],
    exec_mode: 'cluster',
    env_production: {
      NODE_ENV: "production",
    },
    instances: 2
  }],
};
