'use strict'

var restify = require('restify')
var util = require('util')
var utils = require('./utils')

var inspect = util.inspect
var format = util.format
var inspectLog = utils.inspectLog
var logger = utils.getLogger()

exports = module.exports

exports.init = function () {
	var server = restify.createServer({
		name: 'ProjectLP'
	})

	server.use(restify.acceptParser(server.acceptable));
	server.use(restify.queryParser());
	server.use(restify.bodyParser());
	attachEvents(server)
	return server
}

var attachEvents = function (server) {
	logger.info('attaching server events.')

	server.on('uncaughtException', function (req, res, route, err) {
		var inspectErr = inspect(err)
		var inspectRoute = inspect(route)
		logger.error(format('Occur an uncaught exception Error: %s, Route: %s', inspectErr, inspectRoute))
		inspectLog(route)
		res.send(err)
	})

	server.on('after', function (req, res, route, err) {		
		if (!route)
			return			
		var method = route.spec.method
		var path = route.spec.path
		var params = route.params
		logger.info(format('Request "%s" on "%s" with %s.', method, path, JSON.stringify(params)))
	})

	server.pre(function (req, res, next) {
		var defaultVal = 'x-rtm-key-default'
		var authKey = req.header('x-rtm-key', defaultVal)
		if (authKey === defaultVal || authKey.length === 0) {
			var err = new restify.errors.UnauthorizedError('unauthorized.');
			return next(err);
		}

		return next()
	})
}