const db         = require('./models');
const SocketUser = db.socket_users;
const Chat       = db.chats;
const Message    = db.messages;
const Sequelize  = require('sequelize');
const Op         = Sequelize.Op;
var path         = require('path');
// import { writeFile } from "fs";

module.exports = function (io) {
	//create socket connection
	io.on('connection',socket => {
		console.log("A user connected with id: "+socket.id)

		socket.on('connect_user', async function (data) {
			io.to(socket.id).emit('connect_user',data)
			console.log("A user connected with id: "+socket.id)

			//add socket user
			SocketUser.findOne({
				where:{
					user_id:data.user_id,
					user_model:data.user_model
				}
			}).then(async(socketUser)=>{
				if(socketUser){
				socketUser.socket_id = socket.id;
				socketUser.save();
				}
				else{
				await SocketUser.create({
					user_id:data.user_id,
					user_model:data.user_model,
					socket_id:socket.id
				});
				}
				console.log('a user connected'); 
				//socket.emit('connect_user', socket.id);
			}).catch(err => {
				console.log('DB ERROR:',err)
			});

		});

		socket.on('message',async(data) => {
			// console.log("MESSAGE DATA", data);
			var currentdate = new Date(); 
			// var datetime = currentdate.getFullYear() + "-"
			// 		+ String(currentdate.getMonth() + 1).padStart(2, '0')  + "-" 
			// 		+ String(currentdate.getDate()).padStart(2, '0') + " "  
			// 		+ currentdate.getHours() + ":"  
			// 		+ currentdate.getMinutes() + ":" 
			// 		+ currentdate.getSeconds();

			var datetime = currentdate.getFullYear() + "-" +
					String(currentdate.getMonth() + 1).padStart(2, '0') + "-" +
					String(currentdate.getDate()).padStart(2, '0') + " " +
					String(currentdate.getHours()).padStart(2, '0') + ":" +
					String(currentdate.getMinutes()).padStart(2, '0') + ":" +
					String(currentdate.getSeconds()).padStart(2, '0');
			data.created_at = datetime;
			io.to(socket.id).emit('message', data);
				let reciever = await SocketUser.findOne({
					attributes:['id','socket_id'],
					where:{ 
						user_id: data.receiver_id
					}   
				});
				if(reciever){
					io.to(reciever.socket_id).emit('message',data);
					// console.log("receiver socket", reciever.socket_id);
				}
				let constantId = 0;
				Chat.findOne({
					attributes:['id'],
					where:{
						[Op.or]:[
							[{
								model_id: data.model_id??null,
								user_one:data.sender_id,
								user_two:data.receiver_id
							}],
							[{
								model_id: data.model_id??null,
								user_two:data.sender_id,
								user_one:data.receiver_id 
							}]
						] ,
					},
					// raw:true 
				}).then(async(chat_record)=>{

					// if(data.hasOwnProperty(message)) {
					if (data.message) {

						Message.create(data).then(async(message)=>{
							
							if(chat_record == null){
								// console.log('here');
								Chat.create({
									model_id:data.model_id??null,
									user_one:data.sender_id,
									user_two:data.receiver_id,
									user_one_model: data.sender_model,
									user_two_model: data.receiver_model,
	
									// lastMessageId:message.id
								}).then((newChatRecord)=>{  
									// console.log(newChatRecord)
									constantId = newChatRecord.id;
									message.chat_id = newChatRecord.id
									message.save();
								});
							}
							else{
								constantId = chat_record.id;
								message.chat_id = chat_record.id;
								message.save();
								// chat_record.lastMessageId = message.id
								// chat_record.save();
							}
						}).catch(err => {
							console.log('DB ERROR:',err)
						});
					} else {
						console.log(data.file_path);
					}
					
				}).catch(err => {
					console.log('DB ERROR:',err)
				});
		});

		socket.on('disconnect',async () => {
			await SocketUser.destroy({
				where: {
					socket_id: socket.id 
				}
			});
			console.log('A user disconnected with id: '+socket.id);
		});

		socket.on('uploadFile',(file)=>{

			io.to(socket.id).emit('uploadFile',file);

			   // save the content to the disk, for example
			// writeFile("public/uploads", file, (err) => {
			// 	callback({ message: err ? "failure" : "success" });
			// });


			console.log('uploading..',file)
			let image = file;
			if (image) {
				
				// var extension = path.extname(file.name);
				var filename = new Date().getTime() + '.jpg';
				var sampleFile = image;
				// console.log(filename, "==========filename");
				filename = 'test-'+filename;
				console.log(filename);
				
				sampleFile.mv(`public`, function(err) { 
					if (err) throw err;
				});

				console.log(filename);
				// return filename;
			}
			// console.log("testing file -------",file)

		});

	});
}