'use strict'

var _ = require('underscore')
var account = require('./account')
var gift = require('./gift')
var order = require('./order')

var routes = [account, gift, order]

exports = module.exports

exports.init = function (server) {
	var doInit = function(ele, i, list){
		ele.init(server)
	}
	
	_.each(routes, doInit)
}