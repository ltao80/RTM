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
		this._verifyStatus = data.verifyStatus : 1;
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
		case 'history':
			this.setupHistoryView(data);
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
			href += "#" items.join('&');
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
			var submitData=[];

			var wrapper=$('#product_list');
			wrapper.children('div').each(function(){
				if($(this).next('ul').length>0){
					$(this).next('ul').children('li').each(function(){
						var liData={
							ProductId:$(this).attr('extra-data'),
							ProductName:$(this).attr('name'),
							Specifications:$(this).attr('size'),
							Credit:$(this).attr('credit')
						};
						$(this).find('span').eq(0).click(function(e){
							e.preventDefault();
							var count=parseInt(li.find('span').eq(1).text())+1;
							var result=_.find(submitData,function(re){
								return re.id==liData.ProductId
							});
							li.find('span').eq(1).text(count);

							if(result){
								result.count=count;
								div.find('i[extra-data='+liData.ProductId+']').text(liData.Specifications+'×'+count)
							}else{
								submitData.push({
									id:liData.ProductId,
									name:liData.ProductName,
									size:liData.Specifications,
									count:1,
									credit:liData.Credit
								});
								div.find('p').append('<i extra-data="'+liData.ProductId+'">'+liData.Specifications+'×'+count+'</i>')
							}
						});
						$(this).find('span').eq(2).click(function(){
							var count=parseInt(li.find('span').eq(1).text())-1;
							var result=_.find(submitData,function(re){
								return re.id==liData.ProductId
							});
							if(!result){return}
							var index=_.indexOf(submitData,result);
							if(count<=0){
								li.find('span').eq(1).text(0);
								submitData.splice(index,1);
								div.find('i[extra-data='+liData.ProductId+']').remove();
								return
							}
							li.find('span').eq(1).text(count);
							result.count=count;
							div.find('i[extra-data='+liData.ProductId+']').text(liData.Specifications+'×'+count)
						})
					})
				}
				$(this).toggle(function(){
					ul.slideDown(200);
					$(this).addClass('opened')
				},function(){
					ul.slideUp(200);
					$(this).removeClass('opened')
				})
			});

			$('#submit').click(function(){
				if(submitData.length==0){alert('请选择产品');return}
				var total=0;
				submitData.forEach(function(item,i){
					total=total+item.credit*item.count;
					//submitData[i]=([item.id,item.name,item.size,item.count,item.credit].join(','))
				});
				submitData={
					data:submitData,
					total:total
				}
				$('#product_data').val(JSON.stringify(submitData));
				alert(JSON.stringify(submitData));
				$('#product_form').submit()
			})
		});
	},
	setupConfirmUserView: function(data) {
		this.loadView(data, function(data) {
			resetWindow();

			function slider(el){
				this.slider=el;
				this.icon=this.slider.getElementsByTagName('div')[0];
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
						event.preventDefault()
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
					var self = this;
					if(!!this.touch){
						this.slider.addEventListener('touchstart',self.start.bind(this));
						this.slider.addEventListener('touchmove',self.move.bind(this));
						this.slider.addEventListener('touchend',self.end.bind(this));
						$(this.icon).click(function(){
							$(self.slider).slideUp(100,function(){
								$('#total').val($('#total').val()-$(this).siblings('[name=o_credit]').val()*$(this).siblings('[name=o_count]').val());
								$(this).remove()
							})
						})
					}
				}
			};

			setTimeout(function(){
				var list=document.getElementsByTagName('li');
				for(var i=0; i<list.length; i++){
					//console.log(list[i]);
					slideRun(list[i])
				}
				function slideRun(list){
					var s=new slider(list);
					s.init();
				}
			},100);
		});
	},
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