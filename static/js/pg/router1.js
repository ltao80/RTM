

var router={
    wrapper:$('#wrapper'),
    body:$('#main'),
    /***********************产品列表***************************/
    product:function(){
        router.body.load('../../views/pg/product.html',function(){
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
        })
    },
    /***********************确认订单***************************/
    confirm:function(){
        router.body.load('../../views/pg/confirm.html',function(){
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
        })
    },
    /***********************历史列表***************************/
    history:function(){
        router.body.load('../../views/pg/confirm.html',function(){
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
        })
    }
}

router.product()