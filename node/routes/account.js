'use strict'

var util = require('util')
var utils = require('../utils')

var format = util.format
var logger = utils.getLogger()

exports = module.exports

exports.init = function (server) {
	logger.info('init account apis.')
	server.get('/account/:name', acc.info)
	server.post('/account/:name/login', acc.login)
	server.post('/account/:name/reset', acc.reset)
	server.put('/account/create', acc.create)
	server.patch('/account/frozen', acc.frozen)
	server.del('/account/:name', acc.del)
	server.patch('/account/migrate/:name', acc.migrate)
}

var acc = {
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