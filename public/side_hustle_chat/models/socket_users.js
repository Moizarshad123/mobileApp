/* jshint indent: 1 */

module.exports = function(sequelize, DataTypes) {
	return sequelize.define('socket_users', {
		id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			primaryKey: true,
			autoIncrement: true,
			field: 'id'
		},
		user_id: {
			type: DataTypes.INTEGER(11),
			allowNull: false,
			field: 'user_id'
		},
		user_model: {
			type: DataTypes.STRING(100),
			allowNull: false,
			field: 'user_model'
		},
		socket_id: {
			type: DataTypes.STRING(100),
			allowNull: false,
			field: 'socket_id'
		},
        created_at: {
			type: DataTypes.DATE,
			allowNull: true,
			field: 'created_at'
		},
		updated_at: {
			type: DataTypes.DATE,
			allowNull: true,
			field: 'updated_at'
		}
	}, {
		tableName: 'socket_users',
        createdAt: false,
        updatedAt: false,
	});
};
