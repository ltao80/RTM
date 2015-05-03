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
		var data = this.parseData(params);
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
			this.setupregenerateQrcodeView(data);
			break;
		case 'qrcode_success':
			this.setupQrcodeSuccessView(data);
			break;
		case 'history':
			this.setupHistoryView(data);
			break;
		case 'order_confirm':
			this.setupConfirmView(data);
			break;
		case 'search_detail':
			this.setupSearchDetailView(data);
			break;
		case 'receipt':
			this.setupReceiptView(data);
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
		switch(parseInt(this._verifyStatus)) {
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
	selectedProducts: [],//这里应该为空,然后根据用户的选择添加删除
	setupProductListView: function(data) {
		var self = this;
		this.loadView(data, function(data) {


			//-------------------------------------------/

			var wrapper=$('#product_list');
			wrapper.children('div').each(function(){
				var div=$(this);
				if($(this).next('ul').length>0){
					$(this).next('ul').children('li').each(function(){
						var li=$(this);
						var liData={
							ProductId:li.attr('production-id'),
							ProductName:li.attr('name'),
							Specifications:li.attr('spec-id'),
							Credit:li.attr('credit')
						};
						checkProduct(div,li,liData);
						li.find('span').eq(0).click(function(e){
							e.preventDefault();
							var count=parseInt(li.find('span').eq(1).text())+1;
							var result=_.find(self.selectedProducts,function(re){
								return (re.product_id==liData.ProductId&&re.spec_id==liData.Specifications)
							});
							li.find('span').eq(1).text(count);

							if(result){
								result.count=count;
								div.find('i[extra-data='+liData.Specifications+']').text(liData.ProductName+'×'+count)
							}else{
								self.selectedProducts.push({
									product_id:liData.ProductId,
									spec_id:liData.Specifications,
									count:1,
									name:liData.ProductName,
									score:liData.Credit,
									parentName:div.attr('extra-data')
								});
								div.find('i[extra-data='+liData.Specifications+']').text(liData.ProductName+'×'+count)
							}
						});
						li.find('span').eq(2).click(function(){
							var count=parseInt(li.find('span').eq(1).text())-1;
							var result=_.find(self.selectedProducts,function(re){
								return (re.product_id==liData.ProductId&&re.spec_id==liData.Specifications)
							});
							if(!result){return}
							var index=_.indexOf(self.selectedProducts,result);
							if(count<=0){
								li.find('span').eq(1).text(0);
								self.selectedProducts.splice(index,1);
								div.find('i[extra-data='+liData.Specifications+']').text(liData.ProductName)
								return
							}
							li.find('span').eq(1).text(count);
							result.count=count;
							div.find('i[extra-data='+liData.Specifications+']').text(liData.ProductName+'×'+count)
						})
					});
					div.toggle(function(){
						$(this).next('ul').slideDown(200);
						$(this).addClass('opened')
					},function(){
						$(this).next('ul').slideUp(200);
						$(this).removeClass('opened')
					})
				}
			});

			function checkProduct(div,li,liData){
				var result=_.find(self.selectedProducts,function(re){
					return (re.product_id==liData.ProductId&&re.spec_id==liData.Specifications)
				});
				if(result){
					div.find('i[extra-data='+liData.Specifications+']').text(liData.ProductName+'×'+result.count);
					li.find('span').eq(1).text(result.count)
				}
			}
			//-------------------------------------------/
			$(".product_foot .save-order").click(function() {

				if(self.selectedProducts.length === 0) {
					myAlert({
						mode:1,
						title:'请选择产品用再确认',
						btn1:' 确 定',
						close:function(ele){
							ele.remove()
						},
						btnClick:function(ele){
							ele.remove()
						}
					});
				} else {
					var confirmUrl = self.setupHashParameters({"view": "order_confirm"});
					location.href = confirmUrl
				}
			});
		});
	},
	setupConfirmUserView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			$(".user-confirm-form .provinces").find('li').click(function() {
				var select = this;
				$(".user-confirm-form .cities").empty().siblings('p').text('请选择城市').siblings('input').val('');
				$(".user-confirm-form .stores").empty().siblings('p').text('请选择门店').siblings('input').val('');
				self.loadData("/service/get_cities_by_province", {province: $(select).text()}, function(data) {
					console.log(data);
					if(data && data.length > 0) {
						data.forEach(function(city) {
							$(".user-confirm-form .cities").append('<li value="' + city + '">' + city + '</li>');
						});
					}
					$(".user-confirm-form .cities").find('li').click(function() {
						var select = this;
						$(".user-confirm-form .stores").empty().siblings('p').text('请选择门店').siblings('input').val('');
						self.loadData("/service/get_stores_by_city", {city: $(select).text()}, function(data) {
							if(data && data.length > 0) {
								data.forEach(function(store) {
									$(".user-confirm-form .stores").append('<li value="' + store + '">' + store + '</li>');
								});
							}
							$(".user-confirm-form .cities").find('li').click(function() {
								$(".user-confirm-form .cities ul").empty().siblings('p').text('请选择门店');
							})
							bindDropDown()
						});
					});

					bindDropDown()
				});

			});

			$('.drop_down').click(function(e){
				e.stopPropagation();
				$(this).addClass('drop_down_open')
			});

			function bindDropDown(){
				$('.drop_down li').unbind('.event').bind('click.event',function(){
					setTimeout(function(){
						$(this).parent('ul').siblings('p').text($(this).text());
						$(this).parent('ul').siblings('input').val($(this).text());
						$('.drop_down').removeClass('drop_down_open')
					}.bind(this),0)
				});
			}
			bindDropDown()

			$('body').click(function(){
				$('.drop_down').removeClass('drop_down_open')
			});




			$('#user-confirm-form').validVal({
				form:{
					onInvalid: function( $fields, language ) {
						myAlert({
							mode:1,
							title:'部分信息不完整',
							btn1:' 确 定',
							close:function(ele){
								ele.remove()
							},
							btnClick:function(ele){
								ele.remove()
							}
						});
					},
					onValid:function(){
						var params = {
							"province" : $(".user-confirm-form .provinces").siblings('input').val(),
							"city" : $(".user-confirm-form .cities").siblings('input').val(),
							"store" : $(".user-confirm-form .stores").siblings('input').val(),
							"name" : $(".user-confirm-form .user_name").val(),
							"phone" : $(".user-confirm-form .user_phone").val(),
							"email" : $(".user-confirm-form .user_email").val(),
							"openId" : self._openId
						};
						self.postData("/pg_user/confirm_user", params, function(data) {
							if(data.success) {
								location.href = self.setupHashParameters({"view" : "signin"});
							} else {
								myAlert({
									mode:1,
									title:'信息错误，请重新核对。',
									content:'请立即咨询人头马官方账号客服或者上报PTL',
									btn1:' 确 定',
									close:function(ele){
										ele.remove()
									},
									btnClick:function(ele){
										ele.remove()
									}
								});
							}
						});
						return false
					}
				}
			});

			$('#user-confirm-form').submit(function(){
				return false
			});

		});
	},
	
	setupSearchOrderView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			$(".search-order-form .query-order").click(function() {
				var receiptId = $(".search-order-form .receipt-id").val();
				if(receiptId.trim() == '') {
					myAlert({
						mode:1,
						title:'请输入收据号',
						btn1:' 确 定',
						close:function(ele){
							ele.remove()
						},
						btnClick:function(ele){
							ele.remove()
						}
					})
				} else {
					self.postData("/order_offline/find_order_by_receipt", {openId: self._openId, receiptId: receiptId}, function(data) {
						if(data.order_code) {
							self._orderCache[data.order_code] = data;
							location.href = self.setupHashParameters({view: 'regenerate_qrcode', order_code: data.order_code});
						} else {
							myAlert({
								mode:1,
								title:'没有找到相应的订单',
								btn1:' 确 定',
								close:function(ele){
									ele.remove()
								},
								btnClick:function(ele){
									ele.remove()
								}
							})
						}
					});
				}
			});
		});
	},
	orderPageIndex: 1,
	setupHistoryView:function(data){
		var self = this;
		this.loadView(data, function(data) {



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
				if(isLoading){return}
				isLoading=true;
				$.ajax({
					type:'post',
					url:'/order_offline/get_orders?openId='+self._openId+'&pageIndex='+self.orderPageIndex+'&pageSize=10&detail=true',
					dataType:'json',
					success:function(data){
						if(data.data) {
							if(!data.data.length){return}
							self.orderPageIndex++;
							isLoading = false;
							if (data.data && data.data.length > 0) {
								data.data.forEach(function (item) {
									var li = $('<li><h1>订单号：' + item.order_code + '<span>' + item.order_datetime + '</span></h1></li>')
									item.details.forEach(function (item2) {
										li.append('<p>' + item2.name + ' ' + item2.spec_name + ' x' + item2.product_num + '</p>')
									});
									li.append('<h2>积分总计：<i>' + (item.total_score ? item.total_score : 0) + '</i>积分</h2>');
									$('.history_list').append(li)
								});
								$('#history_head').prepend('<p>已积分总计：<i>'+data.sum_score+'</i>积分</p>');
							}
						}
					},
					error:function(){
						$('.scroll_more').unbind().html('<p>已全部加载</p>')
					}
				})
			}
		})
	},
	setupSigninView: function(data) {
		var self = this;
		this.loadView(data, function(data) {
			var productViewUrl = self.setupHashParameters({"view": "products"});
			$(".user-signin-form .user-signin").click(function() {
				var password = $(".user-signin-form .user-password").val();
				if(password === '') {
					myAlert({
						mode:1,
						title:'密码不能为空！',
						btn1:' 确 定',
						close:function(ele){
							ele.remove()
						},
						btnClick:function(ele){
							ele.remove()
						}
					})
				} else {
					self.postData("/pg_user/signin", {
						"password" : password,
						"openId" : self._openId
					}, function(data) {
						if(data.success) {
							if(data.data) {
								$(".user-info-change-confirm").show();
								$('.user-signin-form').hide();
								$(".user-info-change-confirm").find(".changed-info").html(
									"您的信息发生了变化，如下是您的最新信息<br />门店：" + data.data.store_name +", 手机号：" + data.data.phone+ "<br />请确认"
								);
							} else {
								location.href = productViewUrl;
							}
						} else {
							myAlert({
								mode:1,
								title:data.error,
								btn1:' 确 定',
								close:function(ele){
									ele.remove()
								},
								btnClick:function(ele){
									ele.remove()
								}
							})
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
	setupConfirmView:function(data){
		var self = this;
		this.loadView(data, function(data) {

			/*self.selectedProducts.push({
				product_id:liData.ProductId,
				spec_id:liData.Specifications,
				count:1,
				score:liData.Credit
			});*/

			var data=self.selectedProducts;
			data.forEach(function(item){
				var li=$('<div credit="'+item.score+'" spec_id="'+item.spec_id+'"  extra-data="'+item.product_id+'"><h1>'+item.parentName+'</h1><p>'+item.name+'×'+item.count+'</p><div>——</div></div>');
				$('#product_list2').append(li);
			});
			$('#total').text(allScore());

			function allScore(){
				var allScore=0;
				self.selectedProducts.forEach(function(item){
					allScore=allScore+parseInt(item.score)*parseInt(item.count)
				});
				return allScore
			}

			function slider(el){
				this.slider=el;
				this.icon=$(this.slider).children('div');
			}
			slider.prototype = {
				touch:('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
				start:function(event){
					var touch = event.targetTouches[0];
					this.startPos = {x:touch.pageX,y:touch.pageY,time:+new Date};
					this.isScrolling = 0;

				},
				move:function(event){
					var self=this;
					if(event.targetTouches.length > 1 || event.scale && event.scale !== 1) return;
					var touch = event.targetTouches[0];
					this.endPos = {x:touch.pageX - self.startPos.x,y:touch.pageY - self.startPos.y};
					self.isScrolling = Math.abs(self.endPos.x) < Math.abs(self.endPos.y) ? 1:0;
					if(self.isScrolling === 0){
						event.preventDefault();
					}
				},
				end:function(event){
					var self=this;
					var duration = +new Date - self.startPos.time;
					if(self.isScrolling === 0){
						if(Number(duration) > 10){
							if(self.endPos.x > 10){
								$(self.icon).animate({right:'-10.9%'},100)
							}else if(self.endPos.x < -10){
								console.log(self.icon);
								$(self.icon).animate({right:0},100)
							}
						}
					}
				},
				init:function(){
					var self0 = this;
					if(!!this.touch){
						this.slider.addEventListener('touchstart',self0.start.bind(this));
						this.slider.addEventListener('touchmove',self0.move.bind(this));
						this.slider.addEventListener('touchend',self0.end.bind(this));
					}
					$(this.icon).click(function(){
						$(self0.slider).slideUp(100,function(){
							var id=$(self0.slider).attr('extra-data');
							var specId=$(self0.slider).attr('spec_id');
							var result=_.find(self.selectedProducts,function(re){
								return (re.product_id==id&&re.spec_id==specId)
							});
							console.log(id);
							console.log(specId);
							console.log(self.selectedProducts);
							console.log(result);
							if(!result){$(this).show();return}
							var index=_.indexOf(self.selectedProducts,result);
							self.selectedProducts.splice(index,1);

							$('#total').text(allScore());
							$(this).remove()
						})
					})
				}
			};

			setTimeout(function(){
				var list=$('.product_list2>div');
				list.each(function(){
					console.log($(this)[0]);
					slideRun($(this)[0])
				});
				function slideRun(list){
					var s=new slider(list);
					s.init();
				}
			},100);

			$('#submit').click(function(){
				if(self.selectedProducts.length === 0) {
					myAlert({
						mode:1,
						title:'请选择产品用再确认',
						btn1:' 确 定',
						close:function(ele){
							ele.remove()
						},
						btnClick:function(ele){
							ele.remove()
						}
					});
				} else {
					myAlert({
						mode:2,
						title:'是否生成二维码？',
						btn1:'生 成',
						btn2:'不生成',
						close:function(ele){
							ele.remove()
						},
						btnClick:function(ele){
							self.postData("/order_offline/save_order_qrcode", {
								openId: self._openId,
								details: JSON.stringify(self.selectedProducts),
								isGenerateQRCode: 1
							}, function(url) {
								if(url.success){
									self.qrUrl=url.ticket
								}
								var qrkUrl = self.setupHashParameters({"view": "regenerate_qrcode"});
								location.href = qrkUrl;
							});
							ele.remove()
						},
						btnClick2:function(ele){
							self.postData("/order_offline/save_order", {
								openId: self._openId,
								details: JSON.stringify(self.selectedProducts),
								isGenerateQRCode: 0
							}, function(data) {
                                if(data.success) {
                                    if(data.data) {
                                        qrcode = self.setupHashParameters({"view": "receipt",id:data.data});
                                        //alert(qrcode);
                                        location.href = qrcode;
                                    }
                                } else {
                                    alert(data.error);
                                }
							});
							ele.remove()
						}
					});
				}
			});
			$('#back').click(function(){
				var backUrl = self.setupHashParameters({"view": "products"});
				location.href = backUrl;
			})
		})
	},
	setupregenerateQrcodeView:function(data){
		var self = this;
		this.loadView(data, function(data) {
			if(self.qrUrl){
				$('#qrCode_img').attr('src',self.qrUrl)
			}
		})
	},
	setupQrcodeSuccessView:function(data){
		var self = this;
		this.loadView(data, function(data) {

		})
	},
	setupSearchDetailView:function(data){
		var self = this;
		this.loadView(data, function(data) {

		})
	},
	setupReceiptView:function(data){
		var self = this;
		var oData=data;
		this.loadView(data, function(data) {
			$('#submit').click(function(){
				self.postData("/pg_index/save_receipt", {
					receiptId: $('#receipt_id').val(),
					orderCode:oData.id
				}, function(data) {
					if(!data.error){
						myAlert({
							mode:1,
							title:'录入成功！',
							btn1:' 确 定',
							close:function(ele){
								ele.remove()
							},
							btnClick:function(ele){
								ele.remove()
							}
						});
					}else{
						myAlert({
							mode:1,
							title:'录入失败',
							btn1:' 确 定',
							close:function(ele){
								ele.remove()
							},
							btnClick:function(ele){
								ele.remove()
							}
						});
					}
				});
			})
		})
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