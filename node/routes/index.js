'use strict'

var _ = require('underscore')
var account = require('./account')

var routes = [account]

exports = module.exports

exports.init = function (server) {
	var doInit = function(ele, i, list){
		ele.init(server)
	}
	
	_.each(routes, doInit)
}