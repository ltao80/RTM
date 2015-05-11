'use strict'

var utils = require('../utils')
var productRepo = require('../repositories/product')
var exceptions = require('../exceptions')
var _ = require('underscore')

var format = utils.format
var inspectLog = utils.inspectLog
var logger = utils.getLogger()
var httpEx = exceptions.http

exports = module.exports

exports.init = function (server) {
	logger.info('init product apis.')
	server.get('/product/list', product.list)
	server.patch('/product/:id/updateStatus/:status', product.updateStatus)
	server.del('/product/:id/', product.delete)
	server.del('/product/', product.deleteBatch)
	server.get('/product/:id', product.info)
	server.post('/product/', product.create)
	server.put('/product/:id', product.update)
	server.get('/product/category', product.getCategory)
}

var product = {
	list: function (req, res, next) {
		var p = ['startId', 'take']
		var params = req.params
		var r = utils.checkParams(p, params)
		if (!r.isOk) {
			var msg = format('Missing parameters. [%s]', r.missed.join(', '))
			return next(httpEx.badRequestError(msg))
		}
		var startId = parseInt(params.startId)
		var take = parseInt(params.take)
		var status = params.status || 1
		var category = params.category || 0
		var data = {
			startId: startId,
			take: take,
			status: status,
			category: category
		}
		productRepo.getList(data, function (err, rows) {
			if (err)
				res.send(err)
			else
				res.send(rows)
			next()
		})
	},
	updateStatus: function (req, res, next) {
		var p = ['id', 'status']
		var params = req.params
		var r = utils.checkParams(p, params)
		if (!r.isOk) {
			var msg = format('Missing parameters. [%s]', r.missed.join(', '))
			return next(httpEx.badRequestError(msg))
		}

		var doRes = function (err, ret) {
			if (err)
				res.send(err)
			else
				res.send(ret.toString())
			next()
		}

		var id = params.id
		var status = params.status
		var doUpdate = productRepo.updateStatus
		if (id.indexOf(',') > -1) {
			id = _.map(id.split(','), function (id) {
				return parseInt(id)
			})
			doUpdate = productRepo.updateStatusBatch
		}

		doUpdate(id, status, doRes)
	},
	updateStatusBatch: function (req, res, next) {
		console.log(1)
		var p = ['ids', 'status']
		var params = req.params
		var r = utils.checkParams(p, params)
		if (!r.isOk) {
			var msg = format('Missing parameters. [%s]', r.missed.join(', '))
			return next(httpEx.badRequestError(msg))
		}

		var ids = params.ids
		var status = params.status
		var idList = _.map(ids.split(','), function (id) {
			return parseInt(id)
		})
		productRepo.updateStatusBatch(idList, status, function (err, rows) {
			if (err)
				res.send(err)
			else
				res.send(rows)
			next()
		})
	},
	delete: function (req, res, next) {
		var params = req.params
		var productId = params.productId
	},
	deleteBatch: function (req, res, next) {

	},
	info: function (req, res, next) {
		var params = req.params
		var id = params.id
		productRepo.getById(id, function (err, rows) {
			if (err)
				res.send(err)
			else
				res.send(rows)
			next()
		})
	},
	create: function (req, res, next) {

	},
	update: function (req, res, next) {

	},
	getCategory: function (req, res, next) {

	}
}