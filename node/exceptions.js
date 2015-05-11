'use strict'

var restify = require('restify')

exports = module.exports

exports.http = {
	badRequestError: function(errMsg) {
		return new restify.BadRequestError(errMsg)
	}
}