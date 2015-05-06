'use strict'

var util = require('util')
var utils = require('../utils')

var format = util.format
var logger = utils.getLogger()

exports = module.exports

exports.init = function (server) {
	logger.info('init gift apis.')
	server.get('/gift/list', gift.list)
	server.patch('/gift/:id/changeStatus', gift.changeStatus)
	server.patch('/gift/changeStatus', gift.changeStatusBatch)
	server.del('/gift/:id/', gift.delete)
	server.del('/gift/', gift.deleteBatch)
	server.get('/gift/:id', gift.info)
	server.post('/gift/', gift.create)
	server.put('/gift/:id', gift.update)
	server.get('/gift/category', gift.getCategory)
}

var gift = {
	list: function (req, res, next) {

	},
	changeStatus: function (req, res, next) {

	},
	changeStatusBatch: function (req, res, next) {

	},
	delete: function (req, res, next) {

	},
	deleteBatch: function (req, res, next) {

	},
	info: function (req, res, next) {

	},
	create: function (req, res, next) {

	},
	update: function (req, res, next) {

	},
	getCategory: function(req, res, next)
}