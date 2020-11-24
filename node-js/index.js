const express = require('express')
const app = express()
const port = 8888
const redis = require('redis');
const client = redis.createClient(); // this creates a new client

app.get('/creat/:key/value/:value', function(req, res) {
res.send(req.params)
client.set(req.params.key, req.params.value, redis.print);});

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
client.del(req.params.key, redis.print);});


app.listen(port, function(){
  console.log(`Example listening at http://192.168.56.101:${port}`)
})
