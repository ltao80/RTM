var VerifyStatus = {
	NOT_INITIALIZED: 1,
	NEED_SIGNIN: 2,
	NOT_NEED_SIGNIN: 3
};
var PGMainController = {
    _openId: null,
    _verifyStatus: 1,
    _contentContainer: null,
    _orderCache: {},
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
			this.setupSigninView(data);
			break;
		case 'search_order':
			this.setupSearchOrderView(data);
			break;
		case 'regenerate_qrcode':
			break;
		case 'history':
			this.setupHistoryView(data);
			break;
		case 'default':
		default:
			this.handleIndex(data);
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
	handleIndex: function(data) {
		switch(this._verifyStatus) {
		case VerifyStatus.NOT_INITIALIZED:
			location.href = this.setupHashParameters({view: "confirm_user"});
			break;
		case VerifyStatus.NEED_SIGNIN:
			location.href = this.setupHashParameters({view: "signin"});
			break;
		case VerifyStatus.NOT_NEED_SIGNIN:
			location.href = this.setupHashParameters({view: "products"});
			break;
		}
	},
	selectedProducts: [{product_id: 1, spec_id: 70, count: 3, score: 500},{product_id: 4, spec_id: 150, count: 1, score: 300}],//这里应该为空,然后根据用户的选择添加删除
	setupProductListView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			$(".product_foot .save-order").click(function() {
				if(self.selectedProducts.length === 0) {
					alert("请选择产品用再确认");
				} else {
					var result = confirm("是否生成二维码？");
					
					var isGenerateQRCode = result ? "1" : "0";
					self.postData("/order_offline/save_order", {
						openId: self._openId,
						details: JSON.stringify(self.selectedProducts),
						isGenerateQRCode: isGenerateQRCode
					}, function(data) {
						
					});
				}
			});
		});
	},
	setupConfirmUserView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			$(".user-confirm-form .provinces").change(function() {
				var select = this;
				$(".user-confirm-form .cities").empty().append('<option value="-1">请选择城市</option>');
				$(".user-confirm-form .stores").empty().append('<option value="-1">请选择门店</option>');
				self.loadData("/service/get_cities_by_province", {province: $(this).val()}, function(data) {
					if(data && data.length > 0) {
						data.forEach(function(city) {
							$(".user-confirm-form .cities").append('<option value="' + city + '">' + city + '</option>');
						});
					}
				});
			});
			
			$(".user-confirm-form .cities").change(function() {
				var select = this;
				$(".user-confirm-form .stores").empty().append('<option value="-1">请选择门店</option>');
				self.loadData("/service/get_stores_by_city", {city: $(this).val()}, function(data) {
					if(data && data.length > 0) {
						data.forEach(function(store) {
							$(".user-confirm-form .stores").append('<option value="' + store + '">' + store + '</option>');
						});
					}
				});
			});
			
			$(".user-confirm-form .submit-user-info").click(function() {
				var params = {
					"province" : $(".user-confirm-form .provinces").val(),
					"city" : $(".user-confirm-form .cities").val(),
					"store" : $(".user-confirm-form .stores").val(),
					"name" : $(".user-confirm-form .user_name").val(),
					"phone" : $(".user-confirm-form .user_phone").val(),
					"email" : $(".user-confirm-form .user_email").val(),
					"openId" : self._openId
				};
				self.postData("/pg_user/confirm_user", params, function(data) {
					if(data.success) {
						location.href = self.setupHashParameters({"view" : "signin"});
					} else {
						alert("信息错误，请重新核对。请立即咨询人头马官方账号客服或者上报PTL");//TODO:请郑坤替换为自定义的alert
					}
				});
			});
		});
	},
	
	setupSearchOrderView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			$(".search-order-form .query-order").click(function() {
				var receiptId = $(".search-order-form .receipt-id").val();
				if(receiptId.trim() == '') {
					alert("请输入收据号");
				} else {
					self.postData("/order_offline/find_order_by_receipt", {openId: self._openId, receiptId: receiptId}, function(data) {
						if(data.order_code) {
							self._orderCache[data.order_code] = data;
							location.href = self.setupHashParameters({view: 'regenerate_qrcode', order_code: data.order_code});
						} else {
							alert("没有找到相应的订单");
						}
					});
				}
			});
		});
	},
	orderPageIndex: 1,
	setupHistoryView:function(){
		var isLoading=false;
		
		$(window).scroll(function(){
			var scrollTop = $(this).scrollTop();
			var scrollHeight = $(document).height();
			var windowHeight = $(this).height();
			if(scrollTop + windowHeight>=scrollHeight-50){
				loadMore()
			}
		});

		$('.scroll_more').click(loadMore);
		if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch){
			$('.scroll_more')[0].addEventListener('touchstart',loadMore);
		}
		loadMore();

		function loadMore(){
			isLoading=true;
			$.ajax({
				type:'GET',
				url:'history.json',
				dataType:'json',
				success:function(data){
					isLoading=false;
					if(data&&data.length>0){
						data.forEach(function(item){
							var li=$('<li><h1>订单号：'+item.TreeContext[0].orderid+'<span>'+item.TreeContext[0].orderdate+'</span></h1></li>')
							item.TreeContext.forEach(function(item2){
								li.append('<p>'+item2.productname+' '+item2.specifications+' x'+item2.num+'</p>')
							});
							li.append('<h2>积分总计：<i>'+(item.credittotal?item.credittotal:0)+'</i>积分</h2>');
							$('.history_list').append(li)
						})
					}
				}
			})
		}
	},
	setupSigninView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			var productViewUrl = self.setupHashParameters({"view": "products"});
			$(".user-signin-form .user-signin").click(function() {
				var password = $(".user-signin-form .user-password").val();
				if(password === '') {
					alert('密码不能为空！');
				} else {
					self.postData("/pg_user/signin", {
						"password" : password,
						"openId" : self._openId
					}, function(data) {
						if(data.success) {
							if(data.data) {
								$(".user-info-change-confirm").show();
								$(".user-info-change-confirm").find(".changed-info").html(
									"您的信息发生了变化，如下是您的最新信息<br />门店：" + data.data.store_name +", 手机号：" + data.data.phone+ "<br />请确认"
								);
							} else {
								location.href = productViewUrl;
							}
						} else {
							alert(data.error); 
						}
					});
				}
			});
			$(".user-info-change-confirm .user-confirm").click(function() {
				self.postData("/pg_user/confirm_change", {openId: self._openId}, function(data) {
					location.href = productViewUrl;
				});
			});
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
	loadData: function(url, params, callback) {
		$.getJSON(url, params, function(data) {
			callback(data);
		});
	},
	postData: function(url, params, callback) {
		$.post(url, params, function(data) {
			callback(data);
		}, 'json');
	}
};

PGMainController.initialize();