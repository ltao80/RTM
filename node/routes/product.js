'use strict'

var util = require('util')
var utils = require('../utils')

var format = util.format
var logger = utils.getLogger()

exports = module.exports

exports.init = function (server) {
	logger.info('init product apis.')
	server.get('/product/list', product.list)
	server.patch('/product/:id/changeStatus', product.changeStatus)
	server.patch('/product/changeStatus', product.changeStatusBatch)
	server.del('/product/:id/', product.delete)
	server.del('/product/', product.deleteBatch)
	server.get('/product/:id', product.info)
	server.post('/product/', product.create)
	server.put('/product/:id', product.update)
	server.get('/product/category', product.getCategory)
}

var product = {
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
	getCategory: function (req, res, next) {

	}
}