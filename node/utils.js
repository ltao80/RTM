'use strict'

var util = require('util')
var config = require('./config.json')
var log4js = require('log4js')
var fs = require('fs')
var path = require('path')
var _ = require('underscore')

exports = module.exports

var initLogger = function () {
	var logPath = config.server.logPath
	var logName = config.server.logFileName
	if (!fs.existsSync(logPath))
		fs.mkdirSync(logPath)
	var logFilePath = path.join(logPath, logName)
	log4js.loadAppender('file')
	log4js.addAppender(log4js.appenders.file(logFilePath, '', 20480))
	var logger = log4js.getLogger()
	return logger
}

var myLogger = initLogger()

exports.inspectLog = function (obj) {
	console.log(util.inspect(obj))
}

exports.getLogger = function () {
	return myLogger
}

exports.format = util.format

exports.isFunction = function (obj) {
	return typeof obj === 'function'
}

exports.checkParams = function (left, right) {
	var doFilter = function (ele) {
		return !right.hasOwnProperty(ele)
	}

	var list = _.filter(left, doFilter)
	return {
		'isOk': list.length === 0,
		'missed': list
	}
}