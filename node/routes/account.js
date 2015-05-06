'use strict'

var util = require('util')
var utils = require('../utils')

var format = util.format
var logger = utils.getLogger()

exports = module.exports

exports.init = function (server) {
	logger.info('init account apis.')
	server.get('/account/:name', account.info)
	server.post('/account/:name/login', account.login)
	server.post('/account/:name/reset', account.reset)
	server.put('/account/create', account.create)
	server.patch('/account/frozen', account.frozen)
	server.del('/account/:name', account.del)
	server.patch('/account/migrate/:name', account.migrate)
}

var account = {
	info: function (req, res, next) {
		var params = req.params
		res.send(format('you have requested %s', util.inspect(params)))
		return next()
	},
	login: function (req, res, next) {

	},
	reset: function (req, res, next) {

	},
	create: function (req, res, next) {

	},
	frozen: function (req, res, next) {

	},
	del: function (req, res, next) {

	},
	migrate: function (req, res, next) {

	}
}