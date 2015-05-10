'use strict'

var utils = require('../utils')
var mysql = require('mysql')
var config = require('../config.json')
var async = require('async')

exports = module.exports

var inspectLog = utils.inspectLog

var host = config.db.host
var user = config.db.user
var password = config.db.password
var connLimit = config.db.connectionLimit

var pool = mysql.createPool({
	connectionLimit: connLimit,
	host: host,
	user: user,
	password: password
});

exports.exec = function (query, values, cbk) {
	pool.getConnection(function (err, conn) {
		var params = []
		if (utils.isFunction(values))
			cbk = values
		else
			params = values
		var q = conn.query(query, params, function (err, rows) {
			conn.release()
			if (!cbk)
				return
			if (err)
				cbk(err)
			else
				cbk(null, rows)
		})
		console.log(q.sql)
	})
}