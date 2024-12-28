<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Node - Socket</title>
</head>
<body onload="getSender()">
    <h1>GET RESPONSE</h1>
    <button id="submit" type="button" onclick="sendMsg()">Send Message</button> | 
    <button id="connectUser" type="button" onclick="connectUsr()">Connect Socket User</button>
    <input type="file" id="uploadFile" type="file" onchange="uploadFile()"/>
    <span id="serverMsg"></span>
    <span id="chatMsg"></span>
   
    <!-- <script src="../node_modules/socket.io/dist/socket.js"></script> -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js" crossorigin="anonymous"></script>
    <script>
        var senderId = 0;
        var receiverId = 0;
        function getSender() {
            this.senderId = prompt("Please enter sender id");
            this.receiverId = prompt("Please enter receiver id");
        }
        const socket = io('{{env("SOCKET_URL")}}');

        console.log(senderId, receiverId, socket);
        socket.on('connect',() => {
            console.log("Check ".socket.id);
        });
        let submit = document.getElementById('submit');
        submit = addEventListener('click',(e) => {
            e.preventDefault();
            let data = {
                sender_id: this.senderId,
                sender_model: 'emp',
                receiver_id: this.receiverId,
                message: "Hey, there is a message"
            }
            socket.emit('message',data);
        });

        let connectUser = document.getElementById('connectUser');
        connectUser = addEventListener('click',(e) => {
            e.preventDefault();
            socket.emit('connect_user',{user_id:this.senderId,user_model:'task_giver'});
        });

        function sendMsg(){
            let data = {
                sender_id: this.senderId,
                sender_model: 'emp',
                receiver_id: this.receiverId,
                message: "Hey, there is a message"
            }
            socket.emit('message',data);
        }
        function uploadFile(){
            var input = document.getElementById('uploadFile');
            var file = input.files[0];
            socket.emit('uploadFile',file);
        }

        function connectUsr(){
            socket.emit('connect_user',{user_id:this.senderId,user_model:'tasker'});
        }

        function sendFile(){
            
        }

        socket.on('message', (data) => {
            console.log(data)
            var item = document.createElement('p');
            item.textContent =  data.message;
            let serverMsgList = document.getElementById('chatMsg');
            serverMsgList.appendChild(item);
        });

        socket.on('serverMessage', (msg) => {
            var item = document.createElement('p');
            item.textContent =  msg;
            let serverMsgList = document.getElementById('serverMsg');
            serverMsgList.appendChild(item);
        });
    </script>
</body>
</html>