var VerifyStatus = {
	NOT_INITIALIZED: 1,
	NEED_SIGNIN: 2,
	NOT_NEED_SIGNIN: 3
};
var PGMainController = {
    _openId: null,
    _verifyStatus: 1,
    _contentContainer: null,
	initialize: function() {
		this._contentContainer = $("#main");
		this.setupHashController();
		this.parseQueryString();
	},
	parseQueryString: function() {
		var search = location.search;
		var params = search.substr(1);
		var data = this.parseData(search);
		this._openId = data.openId ? data.openId : null;
		this._verifyStatus = data.verifyStatus ? data.verifyStatus : 1;
		var object = this.parseData("");
		this.handleHashChange(object);
	},
	parseData: function(params) {
		var data = {};
		var items = params.split('&');
		for(var i = 0; i < items.length; i++) {
			var parts = items[i].split('=');
			data[parts[0]] = (parts[1] ? parts[1] : true);
		}
		
		return data;
	},
	setupHashController: function() {
		var self = this;
		window.onhashchange = function() {
			var data = {view: 'default'}
			var hash = location.hash;
			var params = hash.substr(1);
			var object = self.parseData(params);
			for(var name in object) {
				data[name] = object[name];
			}
			self.handleHashChange(data);
		};
	},
	handleHashChange: function(data) {
		switch(data.view) {
		case 'products':
			this.setupProductListView(data);
			break;
		case 'confirm_user':
			this.setupConfirmUserView(data);
			break;
		case 'signin':
			this.setSignupView(data);
			break;
		case 'regenerate_qrcode':
			break;
			
		case 'default':
		default:
			this.handleDefault(data);
			break;
		}
	},
	setupHashParameters: function(data) {
		var href = location.href;
		var lastIndex = href.lastIndexOf("#");
		lastIndex = lastIndex === -1 ? href.length : lastIndex;
		href = href.substr(0, lastIndex);
		var items = [];
		for(var name in data) {
			items.push(name + '=' + data[name]);
		}
		if(items.length > 0) {
			href += "#" + items.join('&');
		}
		
		return href;
	},
	handleHome: function(data) {
		switch(this._verifyStatus) {
		case VerifyStatus.NOT_INITIALIZED:
			location.href = this.setupHashParameters({view: "confirm_user"});
			break;
		case "2":
			location.href = this.setupHashParameters({view: "signin"});
			break;
		case "3":
			location.href = this.setupHashParameters({view: "products"});
			break;
		}
	},
	setupProductListView: function(data) {
		this.loadView(data, function(data) {
			
		});
	},
	setupConfirmUserView: function(data) {
		this.loadView(data, function(data) {
			
		});
	},
	setupSignupView: function(data) {
		this.loadView(data, function(data) {
			
		});
	},
	loadView: function(data, callback) {
		var items = [];
		for(var name in data) {
			if(name != 'view') {
				items.push(name + '=' + data[name]);
			}
		}
		var viewPath = "/pg_index/" + data.view + '?' + items.join('&');
		this._contentContainer.load(viewPath, function(data) {
			callback(data);
		});
	},
	
};

PGMainController.initialize();