
//var io = require('socket.io').listen(3333);

var express        = require('express');
var app = require('express')();
var fs = require('fs');
var server = require('http').Server(app);
var io = require('socket.io')(server);

app.use(express.static(__dirname + '/public'));

app.get('/', function (req, res) {
  res.sendFile(__dirname + '/index.html');
});

app.get('/chat', function (req, res) {
  res.sendFile(__dirname + '/index.html');
});

server.listen(3333);

//app.use(express.static(__dirname + '/public'));

var chat = io.of('/chat');
var heyupchat = io.of('/heyupchat');
var users = {};
var MongoClient = require('mongodb').MongoClient,
    Server = require('mongodb').Server,
    Db = require('mongodb').Db,
    CollectionDriver = require('./collectionDriver').CollectionDriver;

var mongoHost = 'localhost'; //A
var mongoPort = 27017;
var collectionDriver;
var collectionDriverHeyup;

MongoClient.connect('mongodb://localhost:27017',{ useNewUrlParser: true }, function(err, client) {

  console.log("Connected successfully to server");

  const db = client.db("dicu");
  collectionDriver = new CollectionDriver(db); 

  const heyupdb = client.db("heyup");
  collectionDriverHeyup = new CollectionDriver(heyupdb); 
});

chat.on('connection', function(socket) {
    //console.log("Connnected with Chat server");
    //console.log(socket.id);
    //users.push(socket);
    //console.log(users.length);

    socket.on('login', function(data) {
        var username = data.sender;
        var friend = data.receiver;
        users[username] = socket.id;
        //console.log("login function");
        //console.log(data);
        //console.log(users);

        collectionDriver.findAll('messages', {
            $or: [{
                "receiver": username,
                "sender": friend
            }, {
                "sender": username,
                "receiver": friend
            }]
        }, function(error, objs) {
            //console.log(objs);
            socket.emit('history', objs);
        });
    });


    socket.on('msg', function(data) {
        var from = data.from;
        var to = data.to;
        var chat_id = data.chat_id;
        var socket_id = users[to];
        var message = data.message;
        var image = data.image;
        var hasImage = false;
        var base64Data = '';
        if (image) {
            base64Data = image.replace(/^data:image\/png;base64,/, "");
        }
        if (base64Data.length) {
            hasImage = true;
        }

        var msgObject = {
            "sender": from,
            "receiver": to,
            "chat_id": chat_id,
            "message": message,
            "has_image": hasImage
        };

        collectionDriver.save('messages', msgObject, function(err, docs) {
            msgObject._id = docs._id;
            if (hasImage) {
                //write original image file
                fs.writeFile("public/files/" + docs._id + ".png", base64Data, 'base64', function(err) {
                    //console.log('file written : ' + err);
                    //chat.volatile.emit('chat', msgObject);
                });

                //write thumbnail image file
                fs.writeFile("public/files/thumb" + docs._id + ".png", base64Data, 'base64', function(err) {
                    //console.log('file written : ' + err);
                    chat.volatile.emit('chat', msgObject);
                });
            } else {
                chat.volatile.emit('chat', msgObject);
            }
        });
    });

    socket.on('disconnect', function() {
        //console.log('user disconnected');
        // iterate over users object and get the username for disconnecting socket.id
        for (username in users) {
            if (users[username] === socket.id) {
                delete(users[username]);
                break;
            };
        }

    });
});

heyupchat.on('connection', function(socket) {
    //console.log("Connnected with Chat server");
    //console.log(socket.id);
    //users.push(socket);
    //console.log(users.length);

    socket.on('login', function(data) {
        var username = data.sender;
        var friend = data.receiver;
        users[username] = socket.id;
        //console.log("login function");
        //console.log(data);
        //console.log(users);

        collectionDriverHeyup.findAll('messages', {
            $or: [{
                "receiver": username,
                "sender": friend
            }, {
                "sender": username,
                "receiver": friend
            }]
        }, function(error, objs) {
            //console.log(objs);
            socket.emit('history', objs);
        });
    });


    socket.on('msg', function(data) {
        var from = data.from;
        var to = data.to;
        var chat_id = data.chat_id;
        var socket_id = users[to];
        var message = data.message;
        var image = data.image;
        var hasImage = false;
        var base64Data = '';
        if (image) {
            base64Data = image.replace(/^data:image\/png;base64,/, "");
        }
        if (base64Data.length) {
            hasImage = true;
        }

        var msgObject = {
            "sender": from,
            "receiver": to,
            "chat_id": chat_id,
            "message": message,
            "has_image": hasImage
        };

        collectionDriverHeyup.save('messages', msgObject, function(err, docs) {
            msgObject._id = docs._id;
            if (hasImage) {
                //write original image file
                fs.writeFile("public/files/" + docs._id + ".png", base64Data, 'base64', function(err) {
                    //console.log('file written : ' + err);
                    //chat.volatile.emit('chat', msgObject);
                });

                //write thumbnail image file
                fs.writeFile("public/files/thumb" + docs._id + ".png", base64Data, 'base64', function(err) {
                    //console.log('file written : ' + err);
                    heyupchat.volatile.emit('heyupchat', msgObject);
                });
            } else {
                heyupchat.volatile.emit('heyupchat', msgObject);
            }
        });
    });

    socket.on('disconnect', function() {
        //console.log('user disconnected');
        // iterate over users object and get the username for disconnecting socket.id
        for (username in users) {
            if (users[username] === socket.id) {
                delete(users[username]);
                break;
            };
        }

    });
});