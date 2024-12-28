const express = require('express');
const app = express();
const path = require('path');

const http = require('http').Server(app);
// const port = process.env.PORT || 3014 3017;
const port = 3023;

//attached http server to the socket.io
const io = require('socket.io')(http,{ cors: { origin: '*' } });

//routes
app.get('/',(req,res)=>{
    res.sendFile(path.join(__dirname,'src/index.html'));
});

require('./socket')(io);

http.listen(port, () => {
    console.log(`App listening on port ${port}`);
});



