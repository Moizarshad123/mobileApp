/* jshint indent: 1 */

module.exports = function(sequelize, DataTypes) {
	return sequelize.define('chats', {
		id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			primaryKey: true,
			autoIncrement: true,
			field: 'id'
		},
		// job_id: {
		// 	type: DataTypes.INTEGER(11),
		// 	allowNull: true,
		// 	field: 'job_id'
		// },
		model_id: {
			type: DataTypes.INTEGER(11),
			allowNull: true,
			field: 'model_id'
		},
		model_name: {
			type: DataTypes.INTEGER(11),
			allowNull: true,
			field: 'model_name'
		},
		user_one: {
			type: DataTypes.INTEGER(11),
			allowNull: true,
			field: 'user_one'
		},
		user_two: {
			type: DataTypes.INTEGER(11),
			allowNull: true,
			field: 'user_two'
		},
		user_one_model: {
			type: DataTypes.STRING(100),
			allowNull: true,
			field: 'user_one_model'
		},
		user_two_model: {
			type: DataTypes.STRING(100),
			allowNull: true,
			field: 'user_two_model'
		}
	}, {
		tableName: 'chats',
		createdAt: false,
        updatedAt: false,
	});
};
