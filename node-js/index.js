const express = require('express')
const app = express()
const port = 8888
const redis_module = require('redis');
const redis_config = require('config');
const get_redis = redis_config.get('redis.redisConfig');
const client = redis_module.createClient(get_redis);

app.get('/creat/:key/value/:value', function(req, res) {
    res.send(req.params)
    client.set(req.params.key, req.params.value, redis_module.print);
});

app.get('/read/:key', function(req, res) {
    client.get(req.params.key, (error, result) => {
        if (error) {
            res.send(error);
            throw error;
        }
        res.send(result + '\n');
    });
});

app.get('/del/:key', function(req, res) {
    res.send(req.params)
    client.del(req.params.key, redis_module.print);
});

app.listen(port, function(){
  console.log(`Example listening at http://192.168.56.101:${port}`)
})

