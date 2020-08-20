'use strict';
const bcrpyt = require('bcrypt');

module.exports = {
  up: async (queryInterface, Sequelize) => {
  await queryInterface.bulkInsert('users', [
      {
      name: "Amru Fakharullah",
      profession: "Web Developers",
      role: "admin",
      email: "amruwera891@gmail.com",
      password: await bcrpyt.hash('Sempak1oo%', 12),
      created_at: new Date(),
      updated_at: new Date(),
     },
      {
      name: "Indah Syahya Dinata",
      profession: "Web Designer",
      role: "student",
      email: "indah1731144@itpln.ac.id",
      password: await bcrpyt.hash('Sempak1oo%', 12),
      created_at: new Date(),
      updated_at: new Date(),
     }
     ]);

  },

  down: async (queryInterface, Sequelize) => {
     await queryInterface.bulkDelete('users', null, {});
  }
};
