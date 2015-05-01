

var router={
    wrapper:$('#wrapper'),
    header:$('#header'),
    body:$('#main'),
    initialize:function(){
        $('#link_to_cart').click(this.cart);
        $('#link_to_query').click(this.queryList);
        $('#link_to_oder').click(this.oderList);
        $('#link_to_info').click(this.personalInfo);
        this.index()
    },
    background1:function(){
        if(!$('#background').hasClass('background1')) {
            $('#background').attr('class','background1')
        }
    },
    background2:function(){
        if(!$('#background').hasClass('background2')) {
            $('#background').attr('class','background2')
        }
    },
    addHead:function(title){
        var html=$('<div class="header"><a href="javascript:void(0)" id="nav_menu_open"></a><p>'+title+'</p><img src="images/logo.png" id="logo" /></div>');
        html.find('#logo').click(this.index);
        this.header.empty();
        this.header.html(html)
    },
    hideNav:function(){
        this.header.find('#nav_menu_open').hide()
    },
    index:function(){
        router.body.load('',function(){
            router.header.empty();
            router.body.find('.main_left li').click(function(){
                var id=$(this).attr('extra-data');
                $.ajax({
                    type:'GET',
                    url:'json/data'+id+'.json',
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        if(data.error){
                            alert('内部错误');
                            return
                        }
                        if(data){
                            data=eval('('+data+')');
                            $('#detail_name').text(data.name);
                            $('#detail_size').text(data.size);
                            $('#detail_cost').text(data.cost);
                            $('#detail_pic').attr('src',data.url)
                        }
                    },
                    error:function(){
                        alert('内部错误');
                    }
                })
            });
            router.background2()
        })

    },
    cart:function(){
        router.body.load('../../views/shopping/cart.html',function(){
            var allData=[];
            $('#cart_list li').each(function(){
                var target=$(this);
                $(this).find('.plus').click(function(){
                    $(this).siblings('.count').text(parseInt($(this).siblings('.count').text())+1);
                    selectProduct(target)
                });
                $(this).find('.reduce').click(function(){
                    if(parseInt($(this).siblings('.count').text())>1){
                        $(this).siblings('.count').text(parseInt($(this).siblings('.count').text())-1);
                        selectProduct(target)
                    }
                });
                $(this).find('[name=item]').change(function(){
                    selectProduct(target)
                })
            });

            $('#addAll').change(function(){
                var state=$(this).attr('checked');
                if(state){
                    $('#cart_list [name=item]').attr('checked',true);
                }else{
                    $('#cart_list [name=item]').attr('checked',false);
                }
                $('#cart_list li').each(function(){
                    selectProduct($(this))
                });
            });


            function selectProduct(ele){
                if(ele.find('[name=item]').attr('checked')) {
                    var result = _.find(allData, function (re) {
                        return re.id == ele.attr('productId')
                    });
                    var count = ele.find('.count').text();

                    if (result) {
                        result.count = count;
                        result.credit = ele.attr('credit') * count;
                    } else {
                        allData.push({
                            id: ele.attr('productId'),
                            name: ele.attr('product'),
                            size: ele.attr('size'),
                            count: count,
                            credit: ele.attr('credit') * count
                        })
                    }
                }else{
                    var result = _.find(allData, function (re) {
                        return re.id == ele.attr('productId')
                    });
                    if(result){
                        var index=_.indexOf(allData,result);
                        allData.splice(index,1)
                    }
                }
                var total=0;
                console.log(allData);
                allData.forEach(function(i){
                    total=total+parseInt(i.credit)
                });
                $('#totalCredit').text(total)
            }
            router.background1();
            router.addHead('购物车')
        })
    },
    queryList:function(){
        router.body.load('../../views/shopping/query-list.html',function(){

            router.background1();
            router.addHead('积分查询')
        })
    },
    oderList:function(){
        router.body.load('../../views/shopping/oders-list.html',function(){

            router.background1();
            router.addHead('积分订单')
        })
    },
    personalInfo:function(){
        router.body.load('../../views/shopping/info.html',function(){
            $('#info_form').validVal({
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
                    }
                }
            });
            router.background1();
            router.addHead('个人信息')
        })
    }
}

router.initialize()