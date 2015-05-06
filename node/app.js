'use strict'

var util = require('util')
var utils = require('./utils')
var server = require('./server')
var config = require('./config')
var route = require('./routes')

var format = util.format
var logger = utils.getLogger()

var myServer = server.init()
route.init(myServer)

var port = config.server.port
logger.info(format('Starting Listening on %s', port))
myServer.listen(port)