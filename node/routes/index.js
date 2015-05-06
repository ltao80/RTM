'use strict'

var _ = require('underscore')
var account = require('./account')
var product = require('./product')
var order = require('./order')

var routes = [account, product, order]

exports = module.exports

exports.init = function (server) {
	var doInit = function(ele, i, list){
		ele.init(server)
	}
	
	_.each(routes, doInit)
}