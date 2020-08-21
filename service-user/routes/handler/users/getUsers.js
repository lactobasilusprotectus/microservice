const { User } = require('../../../models');

module.exports = async (req, res) => {
    const userIds = req.query.user_ids || [];

    const sqlOptions = {
        attributes: ['id', 'email', 'name', 'profession', 'role', 'avatar']
    }

    if (userIds.length){
        sqlOptions.where = {
            id: userIds
        }
    }

    const users = await User.findAll(sqlOptions);

    return res.json({
        status: 'success',
        data: users
    })
}