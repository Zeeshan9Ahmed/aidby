const express = require('express');
const app = express();
var fs = require('fs');
const options = {
    key: fs.readFileSync('/home/server1appsstagi/ssl/keys/be60c_d6c69_8e905ddd3bb9d4c5ece4028b9dbb5ff4.key'),
    cert: fs.readFileSync('/home/server1appsstagi/ssl/certs/server1_appsstaging_com_be60c_d6c69_1695868624_7cd578f3f6dcc5667aca7d82c5f047de.crt'),
};
const server = require('https').createServer(options, app);
// const server = require('http').createServer(app);
var io = require('socket.io')(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST","PATCH","DELETE"],
        credentials: true,
        transports: ['websocket', 'polling'],
        allowEIO3: false
    },
});
var mysql = require("mysql");
var con_mysql = mysql.createPool({
    host: "localhost",
    user: "server1appsstagi_aidby_user",
    password: "7wmuSUPAXq9b",
    database: "server1appsstagi_aidby_db",
    debug: true,
    charset:'utf8mb4'
});

var FCM = require('fcm-node');
var serverKey = 'AAAAfhhfffE:APA91bE3nuXVJbv4UHWMsNHdFOJvmVIVB0xsWT11ikuBdnxHyfxVUxb_AKBMXLaTRXm0tL8JaOh21Y7-KNzsoaOgcrDGBJqI6uj479RDRtPjYLL0RDIZNhh-hgfjkjDbUuG2LVx5VcXN'; //put your server key here
var fcm = new FCM(serverKey);

// SOCKET START
io.on('connection', function(socket) {
    console.log('socket connection *** ', socket.connected)
    // GET MESSAGES EMIT
    socket.on('get_messages', function(object) {
        console.log("GET_MESG", object.sender_id)
        var user_room = "user_" + object.sender_id +'_'+ object.receiver_id;
        socket.join(user_room);

        get_messages(object, function(response) {
            if (response) {
                console.log("response response response *** ", response);
                io.to(user_room).emit('response', { object_type: "get_messages", data: response });
            } else {
                console.log("get_messages has been failed...");
                io.to(user_room).emit('error', { object_type: "get_messages", message: "There is some problem in get_messages..." });
            }
        });
    });

    //GET GROUP MESSAGE
    socket.on('group_get_messages', function(object) {
        var group_room = "group_" + object.group_id;
        var sender = "user_" + object.sender_id;
        socket.join(group_room);
        socket.join(sender);
        group_get_messages(object, function(response) {
            if (response) {
                console.log("get_messages has been successfully executed...");
                io.to(sender).emit('response', { object_type: "get_messages", data: response });
            } else {
                console.log("get_messages has been failed...");
                io.to(group_room).emit('error', { object_type: "get_messages", message: "There is some problem in get_messages..." });
            }
        });
    });

    // SEND MESSAGE EMIT
    socket.on('send_message', function(object) {
        var sender_room = "user_" + object.sender_id +'_'+ object.receiver_id;
        var receiver_room = "user_" + object.receiver_id +'_'+ object.sender_id;
        console.log("trting to send mesg", object);
        send_message(object, function(response) {
            if (response) {
               
                if(response[0]['device_token'] == null){
                    io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                    console.log("Successfully sent with response: ");
                }else{
                    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
                        to: response[0]['device_token'], 
                        collapse_key: 'your_collapse_key',
                        
                        notification: {
                            title:'Chat Notification',
                            body:response[0]['name'] + ' Send you a message',
                            user_name: response[0]['name'],
                            notification_type:'chat',
                            other_id:object.sender_id,
                            vibrate:1,
                            sound:1
                        },
                        
                        data: {  //you can send only notification or only data(or include both)
                            title:'Chat Notification',
                            body:response[0]['name'] + ' Send you a message',
                            user_name: response[0]['name'],
                            notification_type:'chat',
                            other_id:object.sender_id,
                            vibrate:1,
                            sound:1
                        }
                    };
                    
                    console.log("response[0] response[0] response[0] /// ", response[0]);
                    console.log("message *** message /// ", message);
                
                    fcm.send(message, function(err, response_two){
                        if (err) {
                            console.log("Something has gone wrong!");
                            io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                        } else {
                            // console.log("send_message has been successfully executed...");
                            io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                            console.log("Successfully sent with response: ", response_two);
                        }
                    });
                }
                
            } else {
                console.log("send_message has been failed...");
                io.to(sender_room).to(receiver_room).emit('error', { object_type: "get_message", message: "There is some problem in get_message..." });
            }
        });
    });

    //SEND GROUP MESSAGE
    socket.on('group_send_message', function(object) {
        var group_room = "group_" + object.group_id;
        socket.join(group_room);
        group_send_message(object, function(response) {
            if (response) {
            
                var g_device_token = response[0]['g_device_token'].split(',');
                
                var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
                    registration_ids: g_device_token, 
                    collapse_key: 'your_collapse_key',
                    
                    notification: {
                        title:'Group Chat Notification',
                        body:response[0]['fname']+' '+ response[0]['lname']+' Send a message',
                        user_name: response[0]['fname'] +' '+ response[0]['lname'],
                        notification_type:'group_chat',
                        other_id:object.group_id,
                        vibrate:1,
                        sound:1
                    },
                    
                    data: {  //you can send only notification or only data(or include both)
                        title:'Group Chat Notification',
                        body:response[0]['fname']+' '+ response[0]['lname']+' Send a message',
                        user_name: response[0]['fname'] +' '+ response[0]['lname'],
                        notification_type:'group_chat',
                        other_id:object.group_id,
                        vibrate:1,
                        sound:1
                    }
                };
                
                fcm.send(message, function(err, response_two){
                    if (err) {
                        console.log("Something has gone wrong!", err);
                        io.to(group_room).emit('response', { object_type: "get_message", data: response[0] });
                    } else {
                        io.to(group_room).emit('response', { object_type: "get_message", data: response[0] });
                        console.log("Successfully sent with response: ");
                    }
                });
            } else {
                console.log("send_message has been failed...");
                io.to(group_room).emit('error', { object_type: "get_message", message: "There is some problem in get_messages..." });
            }
        });
    });
    // DELETE MESSAGE EMIT
    socket.on('delete_message', function(object) {
        var chat_id = object.chat_id;
        var sender_room = "user_" + object.sender_id;
        var receiver_room = "user_" + object.receiver_id;
        delete_message(object, function(response) {
            io.to(sender_room).to(receiver_room).emit('response', { object_type: "delete_message", data: chat_id });
        });
    });

    socket.on('disconnect', function() {
        console.log("Use disconnection", socket.id)
    });
});
// SOCKET END

// GET MESSAGES FUNCTION
var get_messages = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select 
            users.id as user_id,
            users.first_name,
            users.last_name,
            users.profile_image, 
            chats.id as chat_id, 
            chats.sender_id,
            chats.receiver_id, 
            chats.message,
            chats.type,
            chats.created_at,
            chats.deleted_by
            from chats 
            inner join users on chats.sender_id = users.id
            WHERE (chats.sender_id = ${object.sender_id} 
            AND chats.receiver_id=${object.receiver_id}) 
            OR (chats.sender_id=${object.receiver_id} 
            AND chats.receiver_id=${object.sender_id})             
            order by chats.id ASC`, function(error, data) {
                connection.release();
                if (error) {
                    callback(false);
                } else {
                    callback(data);
                }
            });
        }
    });
};

//GROUP MESSAGE
var group_get_messages = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select 
            users.fname,
            users.lname,
            users.profile_image, 
            chats.id as chat_id, 
            chats.sender_id,
            chats.receiver_id, 
            chats.chat_group_id,
            chats.chat_message,
            chats.chat_type,
            chats.created_at
            from chats 
            inner join users on chats.sender_id = users.id
            WHERE chats.chat_group_id=${object.group_id} order by chats.id ASC`, function(error, data) {
                connection.release();
                if (error) {
                    callback(false);
                } else {
                    callback(data);
                }
            });
        }
    });
};

// SEND MESSAGE FUNCTION
var send_message = function(object, callback) {
    // console.log("Send msf call bacj")
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            var new_message = mysql_real_escape_string (object.message);
            connection.query(`INSERT INTO chats (sender_id , receiver_id , message, type,created_at) VALUES ('${object.sender_id}' , '${object.receiver_id}', '${new_message}', '${object.type}',NOW())`, function(error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    console.log("update_list has been successfully executed...");
                    connection.query(`SELECT 
                        u.id as user_id,
                        u.first_name,
                        u.last_name,
                        u.profile_image, 
                        (select device_token from users where id = '${object.receiver_id}') as device_token,
                        c.*
                        FROM users AS u
                        JOIN chats AS c
                        ON u.id = c.sender_id
                        WHERE c.id = '${data.insertId}'`, function(error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });
                }
            });
        }
    });
};

//SEND GROUP MESSAGE
var group_send_message = function(object, callback) {
    console.log("Send msf call bacj")
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            var new_message = mysql_real_escape_string (object.message);
            connection.query(`INSERT INTO chats (sender_id , chat_group_id , chat_message,chat_type,created_at) VALUES ('${object.sender_id}' , '${object.group_id}', '${new_message}','${object.chat_type}',NOW())`, function(error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    console.log("update_list has been successfully executed...");
                    connection.query(`SELECT 
                        u.fname,
                        u.lname,
                        u.profile_image, 
                        u.device_token,
                        c.*,
                        GROUP_CONCAT(g_users.device_token) as g_device_token
                        FROM users AS u
                        JOIN chats AS c
                        ON u.id = c.sender_id
                        
                        inner join chat_group_joins on chat_group_joins.group_id = c.chat_group_id
                        inner join users as g_users on g_users.id = chat_group_joins.user_id
                        
                        WHERE chat_group_joins.status in ('Admin','Joined') AND chat_group_joins.group_id = ${object.group_id} AND c.id = '${data.insertId}'`, function(error, data) {
                        
                        // WHERE c.chat_id = '${data.insertId}'`, function(error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });

                }
            });
        }
    });
};
// DELETE MESSAGE FUNCTION
var delete_message = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            connection.query(`delete from chats where id = '${object.chat_id}'`, function(error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    callback(true);
                }
            });
        }
    });
};

function mysql_real_escape_string (str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
        switch (char) {
            case "\0":
                return "\\0";
            case "\x08":
                return "\\b";
            case "\x09":
                return "\\t";
            case "\x1a":
                return "\\z";
            case "\n":
                return "\\n";
            case "\r":
                return "\\r";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "\\"+char; // prepends a backslash to backslash, percent,
                                  // and double/single quotes
            default:
                return char;
        }
    });
}


// SERVER LISTENER
server.listen(3038, function() {
    console.log("Server is running on port 3038");
});