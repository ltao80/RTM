'use strict'

var utils = require('../utils')
var consts = require('../repositories/consts')
var repo = require('../repositories/repo')

var inspectLog = utils.inspectLog
var format = utils.format

var tables = consts.tables

exports = module.exports

exports.getById = function (id, cbk) {
	var q = 'SELECT pi.`id` AS product_id, pi.`name`, pi.`title`, pi.`description`, pi.`source`, '
	q += 'ps.`id` AS unique_id, ps.`score`, ps.`stock_num`, ps.`exchange_num`, ps.`is_for_exchange`, ps.`status`, '
	q += 'pimg.`thumbnail_url`, pimg.`image_url`, '
	q += 'gs.`spec_name` '
	q += 'FROM %s AS pi '
	q += 'JOIN %s AS ps ON pi.`id` = ps.`product_id` '
	q += 'JOIN %s AS pimg ON pi.`id` = pimg.`product_id` '
	q += 'JOIN %s AS gs ON ps.`spec_id` = gs.`spec_id` '
	q += 'WHERE pi.`id` = ?;'
	var query = format(q, tables.productInfo, tables.productSpecification, tables.productImages, tables.globalSpecification)
	var params = [id]
	repo.exec(query, params, function (err, rows) {
		if (!cbk)
			return
		if (err)
			return cbk(err)
		cbk(null, rows)
	})
}

exports.getList = function (data, cbk) {
	var startId = data.startId
	var take = data.take
	var status = data.status
	var category = data.category
	var q = 'SELECT pi.`id` AS product_id, pi.`name`, pi.`title`, pi.`description`, pi.`source`,'
	q += 'ps.`id` AS unique_id, ps.`spec_id`, ps.`score`, ps.`stock_num`, ps.`exchange_num`, ps.`is_for_exchange`, ps.`status`,'
	q += 'pimg.`thumbnail_url`, pimg.`image_url`, '
	q += 'gs.`spec_name` '
	q += 'FROM %s AS pi '
	q += 'JOIN %s AS ps ON pi.`id` = ps.`product_id` '
	q += 'JOIN %s AS pimg ON pi.`id` = pimg.`product_id` '
	q += 'JOIN %s AS gs ON ps.`spec_id` = gs.`spec_id` '
	q += 'WHERE ps.`id` > ? AND ps.`is_for_exchange` = ? ORDER BY ps.`id` ASC LIMIT ?;'
	var query = format(q, tables.productInfo, tables.productSpecification, tables.productImages, tables.globalSpecification)
	var params = [startId, take, status, category]
	repo.exec(query, params, function (err, rows) {
		if (!cbk)
			return
		if (err)
			return cbk(err)
		cbk(null, rows)
	})
}

exports.updateStatus = function (id, status, cbk) {
	var q = 'UPDATE %s SET `status` = ? WHERE `id` = ?;'
	var query = format(q, tables.productSpecification)
	var params = [status, id]
	repo.exec(query, params, function (err, rows) {
		if (!cbk)
			return
		if (err)
			return cbk(err)		
		var result = rows.changedRows === 1		
		cbk(null, result)		
	})
}

exports.updateStatusBatch = function (idList, status, cbk) {
	var q = 'UPDATE %s SET `status` = ? WHERE `id` IN (?)'
	var query = format(q, tables.productSpecification)
	var ids = idList.join(', ')
	var params = [status, ids]
	repo.exec(query, params, function (err, rows) {
		if (!cbk)
			return
		if (err)
			return cbk(err)
		var result = rows.changedRows === idList.length
		cbk(null, result)
	})
}