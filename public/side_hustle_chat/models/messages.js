/* jshint indent: 1 */

module.exports = function(sequelize, DataTypes) {
	return sequelize.define('messages', {
		id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			primaryKey: true,
			autoIncrement: true,
			field: 'id'
		},
		sender_id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			field: 'sender_id'
		},
		receiver_id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			field: 'receiver_id'
		},
		sender_model: {
			type: DataTypes.STRING(100),
			allowNull: true,
			field: 'sender_model'
		},
        receiver_model: {
			type: DataTypes.STRING(100),
			allowNull: true,
			field: 'receiver_model'
		},
		message: {
			type: DataTypes.TEXT,
			allowNull: true,
			field: 'message'
		},
		type: {
			type: DataTypes.INTEGER(1),
			allowNull: true,
			defaultValue:1,
			field: 'type'
		},
		message_type: {
			type: DataTypes.INTEGER(1),
			allowNull: true,
			defaultValue:1,
			field: 'message_type'
		},
        chat_id: {
			type: DataTypes.INTEGER(11),
			allowNull: true,
			field: 'chat_id'
		},
		is_seen: {
			type: DataTypes.INTEGER(1),
			allowNull: true,
			defaultValue:0,
			field: 'is_seen'
		},
		created_at: {
			type: DataTypes.DATE,
			allowNull: true,
			field: 'created_at'
		},
	}, {
		tableName: 'messages',
        createdAt: false,
        updatedAt: false,
	});
};
