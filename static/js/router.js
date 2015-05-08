var url=window.location.href.split('/');
var openId=null;
var router={
    wrapper:$('#wrapper'),
    header:$('#header'),
    body:$('#main'),
    initialize:function(){
        var self=this;
        $('#nav_menu_close').click(function(){
            location.href = self.setupHashParameters({"view":"index"})
        });
        $('#link_to_cart').click(function(){
            location.href = self.setupHashParameters({"view":"cart"})
        });
        $('#link_to_query').click(function(){
            location.href = self.setupHashParameters({"view":"queryList"})
        });
        $('#link_to_oder').click(function(){
            location.href = self.setupHashParameters({"view":"oderList"})
        });
        $('#link_to_info').click(function(){
            location.href = self.setupHashParameters({"view":"personalInfo"})
        });
        openId=url[url.length-1];
        this.setupHashController();
        location.href = self.setupHashParameters({"view":"index"})
    },
    tempProduct:[],
    parseQueryString: function() {
        var url=window.location.href;
        var object = this.parseData(url);
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
            var data = {view:'default'}
            var hash = location.hash;
            var params = hash.substr(1);
            var object = self.parseData(params);
            for(var name in object) {
                data[name] = decodeURIComponent(object[name]);
            }
            self.handleHashChange(data);
        };
    },
    handleHashChange: function(data) {
        switch(data.view) {
            case 'cart':
                this.cart();
                break;
            case 'queryList':
                this.queryList();
                break;
            case 'oderList':
                this.oderList();
                break;
            case 'personalInfo':
                this.personalInfo();
                break;
            case 'queryDetail':
                this.queryDetail(data.order_code,data.order_type);
                break;
            case 'oderDetail':
                this.oderDetail(data.id);
                break;
            case 'oderConfirm':
                this.oderConfirm();
                break;
            case 'addAddress':
                this.addAddress(data.id);
                break;
            case 'addressList':
                this.addressList();
                break;
            case 'chooseSize':
                this.chooseSize(data.id,data.type);
                break;
            case 'productDetail':
                this.productDetail(data.id,data.size);
                break;
            default:
                this.index();
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
            items.push(name + '=' + encodeURIComponent(data[name]));
        }
        if(items.length > 0) {
            href += "#" + items.join('&');
        }

        return href;
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
        var html=$('<div class="header"><a href="javascript:void(0)" id="nav_menu_open"></a><p>'+title+'</p><img src="/static/images/logo.png" id="logo" /></div>');
        html.find('#logo').click(this.index);
        this.header.empty();
        this.header.html(html);
        window.document.title=title?title:'积分商城'
    },
    hideNav:function(){
        this.header.find('#nav_menu_open').hide()
    },
    /****************************主 页*****************************/
    index:function(){
        var self = this;
        router.body.load('/shopping/home/'+openId,function(){
            router.header.empty();
            $('#detail_pic').attr('extra-data',router.body.find('.main_left li:eq(0)').attr('extra-data'));
            $('.home_button').attr('extra-data',router.body.find('.main_left li:eq(0)').attr('extra-data'));
            router.body.find('.main_left li').click(function(){
                var id=$(this).attr('extra-data');
                $('.home_button').attr('extra-data',id);
                $('.preview img').attr('extra-data',id);
                $.ajax({
                    type:'GET',
                    url:'/product/get_product_json/'+id,
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        if(data.error){
                            myAlert({
                                mode:1,
                                title:'内部错误，请稍后再试',
                                btn1:' 确 定',
                                close:function(ele){
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    ele.remove()
                                }
                            });
                            return
                        }
                        if(data){
                            //data=eval('('+data+')');
                            $('#detail_name').text(data.name);
                            $('#detail_size').text(data.spec_name);
                            $('#detail_cost').text(data.score);
                            $('#detail_pic').attr('src',"/static/images/"+data.image_url);
                            $('#detail_pic').attr('extra-data',id),
                            $('#detail_size').attr('extra-data',data.spec_id)
                        }
                    },
                    error:function(){
                        myAlert({
                            mode:1,
                            title:'内部错误，请稍后再试',
                            btn1:' 确 定',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        });
                    }
                })
            });
            router.body.find('.preview img').click(function(){
                var id=$(this).attr('extra-data');
                location.href = self.setupHashParameters({
                    "view":"productDetail",
                    "id":id,
                    "size":parseInt($('#detail_size').attr('extra-data'))
                })
            });
            router.background2();
            window.document.title='积分商城';
            $('.home_button').click(function(){
                var id=$(this).attr('extra-data');
                location.href = self.setupHashParameters({
                    "view":"productDetail",
                    "id":id,
                    "size":parseInt($('#detail_size').attr('extra-data'))
                })
                /*var id=$(this).attr('extra-data');
                router.chooseSize(id,2)*/
            })
        })

    },
    /****************************菜单四项*****************************/
    cart:function(){
        var self = this;
        router.body.load('/order_online/list_cart',function(){
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
            var isSubmit=false;
            $('#submit').click(function(){
                if(isSubmit){
                    return
                }
                if(!allData.length){
                    myAlert({
                        mode:1,
                        title:'请选择商品',
                        btn1:' 确 定',
                        close:function(ele){
                            ele.remove()
                        },
                        btnClick:function(ele){
                            ele.remove()
                        }
                    });
                    return
                }
                if(parseInt($('#totalCredit').text())>parseInt($('#max').val())){
                    myAlert({
                        mode:1,
                        title:'已超过最大积分（'+$('#max').val()+'）',
                        btn1:' 确 定',
                        close:function(ele){
                            ele.remove()
                        },
                        btnClick:function(ele){
                            ele.remove()
                        }
                    });
                    return
                }

                self.tempProduct=allData;

                location.href = self.setupHashParameters({
                    "view":"oderConfirm"
                })
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
                        var src=ele.find('img').attr('src').split('/');
                        allData.push({
                            id: ele.attr('productId'),
                            name: ele.attr('product'),
                            size: ele.attr('size'),
                            spec_id: ele.attr('spec_id'),
                            count: count,
                            credit: ele.attr('credit') * count,
                            img:src[src.length-1]
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

            $('#delete').click(function(){
                if(!allData.length){
                    myAlert({
                        mode:1,
                        title:'请选择需要删除的商品',
                        btn1:' 确 定',
                        close:function(ele){
                            ele.remove()
                        },
                        btnClick:function(ele){
                            ele.remove()
                        }
                    });
                    return
                }
                var delData=[];
                allData.forEach(function(item){
                    delData.push({
                        product_id:item.id,
                        spec_id:item.spec_id
                    })
                });
                $.ajax({
                    type:'post',
                    url:'/order_online/drop_cart',
                    data:{
                      data:delData
                    },
                    dataType:'json',
                    success:function(data){
                        if(!data.error){
                            myAlert({
                                mode:1,
                                title:'删除成功',
                                btn1:' 确 定',
                                close:function(ele){
                                    location.href = self.setupHashParameters({
                                        "view":"cart"
                                    })
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    location.href = self.setupHashParameters({
                                        "view":"cart"
                                    })
                                    ele.remove()
                                }
                            })
                        }else{
                            myAlert({
                                mode:1,
                                title:'删除失败',
                                btn1:' 确 定',
                                close:function(ele){
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    ele.remove()
                                }
                            })
                        }
                    },
                    error:function(){
                        myAlert({
                            mode:1,
                            title:'删除失败',
                            btn1:' 确 定',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        })
                    }
                })
            });

            router.background1();
            router.addHead('购物车')
        })
    },
    queryList:function(){
        var self = this;
        router.body.load('/score/score_list',function(){
            $('.query_list li').each(function(){
                $(this).find('.detail_btn').click(function(){
                    var id=$(this).attr('extra-data');
                    var order_code=$(this).attr('order_code');
                    var order_type=$(this).attr('order_type');

                    location.href = self.setupHashParameters({
                        "view":"queryDetail",
                        "order_code":order_code,
                        "order_type":order_type
                    })

                    /*myAlert({
                        mode:1,
                        title:'对不起,暂时无法查看',
                        btn1:' 确 定',
                        close:function(ele){
                            ele.remove()
                        },
                        btnClick:function(ele){
                            ele.remove()
                        }
                    });*/
                })
            });
            router.background1();
            router.addHead('积分查询')
        })
    },
    oderList:function(){
        var self = this;
        router.body.load('/order_online/order_list',function(){
            $('.oders_list li').each(function(){
                $(this).find('.detail_btn').click(function(){
                    /*var id=$(this).attr('extra-data');
                    router.oderDetail(id)*/
                    myAlert({
                        mode:1,
                        title:'对不起,暂时无法查看',
                        btn1:' 确 定',
                        close:function(ele){
                            ele.remove()
                        },
                        btnClick:function(ele){
                            ele.remove()
                        }
                    });
                })
            });
            router.background1();
            router.addHead('兑换记录')
        })
    },
    personalInfo:function(){
        var self = this;
        router.body.load('/customer/get/'+openId,function(){



            if($('input[name=info_name]').val()||$('input[name=info_tel]').val()||$('input[name=info_email]').val()||$('input[name=info_birthday]').val()){
                $('input[name=info_name]').attr('disabled','disabled');
                $('input[name=info_tel]').attr('disabled','disabled');
                $('input[name=info_email]').attr('disabled','disabled');
                $('input[name=info_birthday]').attr('disabled','disabled');
                $('#info_form button').text('我要修改').click(function(e){
                    e.preventDefault();
                    $('input').removeAttr('disabled');
                    $(this).unbind().text('确认提交');
                    allowSubmit()
                })
            }else{
                allowSubmit()
            }

            function allowSubmit(){
                $('#info_form').validVal({
                    customValidations:{
                        "info_tel":function(val){
                            if(val.length<11){
                                return false
                            }else{
                                return true
                            }
                        }
                    },
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
                            var isSubmit=false;
                            if(isSubmit){
                                return false
                            }
                            var going=myAlert({
                                mode:0,
                                title:'正在提交',
                                content:'请稍等...',
                                close:function(ele){
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    ele.remove()
                                }
                            });
                            isSubmit=true;

                            $.ajax({
                                type:'post',
                                url:'/customer/update',
                                data:{
                                    name:$('#info_form').find('[name=info_name]').val(),
                                    phone:$('#info_form').find('[name=info_tel]').val(),
                                    birthday:$('#info_form').find('[name=info_birthday]').val(),
                                    email:$('#info_form').find('[name=info_email]').val()
                                },
                                success:function(data){
                                    isSubmit=false;
                                    going.remove();
                                    if(!data.error){
                                        myAlert({
                                            mode:1,
                                            title:'提交成功',
                                            content:'',
                                            btn1:' 确 定',
                                            close:function(ele){
                                                ele.remove();
                                                location.href = self.setupHashParameters({
                                                    "view":"personalInfo"
                                                })
                                            },
                                            btnClick:function(ele){
                                                ele.remove();
                                                location.href = self.setupHashParameters({
                                                    "view":"personalInfo"
                                                })
                                            }
                                        });
                                    }else{
                                        myAlert({
                                            mode:1,
                                            title:'提交失败',
                                            content:'',
                                            btn1:' 确 定',
                                            close:function(ele){
                                                ele.remove()
                                            },
                                            btnClick:function(ele){
                                                ele.remove()
                                            }
                                        });
                                    }
                                },
                                error:function(){
                                    isSubmit=false;
                                    going.remove();
                                    myAlert({
                                        mode:1,
                                        title:'提交失败',
                                        content:'请稍后再试',
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
                })
            }

            router.background1();
            router.addHead('个人信息')
        })
    },
    /**************************积分查询订单详细页,订单确认页*****************************/
    queryDetail:function(order_code,order_type){
        var self = this;
        router.body.load('/score/score_detail/'+order_code+'/'+order_type,function(){
            router.background1();
            router.addHead('积分查询')
        })
    },
    oderDetail:function(id){
        var self = this;
        router.body.load('/order-online/order_detail/'+id,function(){
            router.background1();
            router.addHead('兑换记录')
        })
    },
    oderConfirm:function(){
        var self = this;
        var data=self.tempProduct;

        router.body.load('/order_online/confirm_order',function(){
            var count=0;
            var score=0;
            data.forEach(function(item){
                var li=$('<div class="oders_main oders_main2">'+
                            '<div class="confirm_img"><img src="/static/images/'+item.img+'" /></div>'+
                            '<p>'+item.name+'</p>'+
                            '<h2>规格：'+item.size+'</h2>'+
                            '<h3><i>'+parseInt(parseInt(item.credit)/parseInt(item.count))+'</i> 积分</h3>'+
                        '</div>');
                $('#oders_main2_list').append(li);
                $('#oders_main2_list2').append(li.clone());
                count=count+parseInt(item.count);
                score=score+parseInt(item.credit);
            });
            $('#count').text(count);
            $('#score').text(score);

            $('#new_address').click(function(){
                location.href = self.setupHashParameters({
                    "view":"addAddress",
                    "id":0
                })
            });
            $('#select_address').click(function(){
                location.href = self.setupHashParameters({
                    "view":"addressList"
                })
            });

            document.body.scrollTop=0;

            $('#addr_form').validVal({
                form:{
                    onInvalid: function( $fields, language ) {
                        myAlert({
                            mode:1,
                            title:'请选择地址',
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
                        var isSubmit=false;
                        if(isSubmit){
                            return false
                        }
                        var going=myAlert({
                            mode:0,
                            title:'正在提交',
                            content:'请稍等...',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                ele.remove()
                            }
                        });
                        isSubmit=true;

                        var finalData=[];
                        data.forEach(function(item){
                            finalData.push({
                                id:item.id,
                                spec_id:item.spec_id,
                                count:item.count
                            })
                        });

                        $.ajax({
                            type:'post',
                            url:'/order_online/make',
                            data:{
                                message:$('#addr_form').find('[name=message]').val(),
                                delivery_id:$('#addr_form').find('[name=address]').val(),
                                product_list:finalData,
                                delivery_thirdparty_code:''
                            },
                            success:function(data){
                                isSubmit=false;
                                if(!data.error){
                                    self.tempProduct=[];
                                    myAlert({
                                        mode:2,
                                        title:'兑换成功',
                                        btn1:'继续兑换',
                                        btn2:'查看订单',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"index"
                                            });
                                            ele.remove()
                                        },
                                        btnClick2:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"oderList"
                                            });
                                            ele.remove()
                                        }
                                    });
                                }else{
                                    myAlert({
                                        mode:1,
                                        title:'兑换失败',
                                        content:'请稍后再试',
                                        btn1:' 确 定',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            ele.remove()
                                        }
                                    });
                                }

                            },
                            error:function(){
                                isSubmit=false;
                                myAlert({
                                    mode:1,
                                    title:'兑换失败',
                                    content:'请稍后再试',
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

            $('#close').click(function(){
                $('#confirm').hide()
            });
            $('#submit').click(function(e){
                e.preventDefault();
                $('#confirm').show();

            });
            $('#back').click(function(){
                $('#confirm').hide()
            });
            $('#submit2').click(function(){
                $('#confirm').hide();
                $('#addr_form').submit()
            })

            router.background1();
            router.addHead('订单确认')
        })
    },
    /****************************新建,选择地址******************************/
    addAddress:function(id){
        var self = this;
        id=parseInt(id)?parseInt(id):0;
        router.body.load('/customer/index_delivery/'+id,function(){

            $.getJSON("/static/json/geographic.json",function(result){
                console.log(result);
                result.forEach(function(item){
                    var option=$('<option value="'+item.n+'">'+item.n+'</option>');
                    option.data(item.s);
                    $('[name=info_province]').append(option)
                });

                $('[name=info_province]').change(function(){
                    var target=$(this).find('option:selected');
                    $('[name=info_city]').empty().append('<option value="">市</option>');
                    $('[name=info_region]').empty().append('<option value="">区</option>');
                    if(target.data()){
                        _.toArray(target.data()).forEach(function(item){
                            var option=$('<option value="'+item.n+'">'+item.n+'</option>');
                            option.data(item.s);
                            $('[name=info_city]').append(option)
                        })
                        $('[name=info_city]').change(function(){
                            var target=$(this).find('option:selected');
                            $('[name=info_region]').empty().append('<option value="">区</option>');
                            if(_.toArray(target.data()).length){
                                _.toArray(target.data()).forEach(function(item){
                                    var option=$('<option value="'+item.n+'">'+item.n+'</option>');
                                    option.data(item.s);
                                    $('[name=info_region]').append(option)
                                })
                            }else{
                                var option=$('<option value="'+target.val()+'">'+target.val()+'</option>');
                                $('[name=info_region]').append(option)
                            }
                        });
                    }
                })
            });

            var isDefault=1;

            $('#info_form').validVal({
                customValidations:{
                    "info_tel":function(val){
                        if(val.length<11){
                            return false
                        }else{
                            return true
                        }
                    }
                },
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
                        var isSubmit=false;
                        if(isSubmit){
                            return false
                        }
                        isSubmit=true;
                        $.ajax({
                            type:'post',
                            url:'/customer/edit_delivery/'+id,
                            data:{
                                name:$('#info_form').find('[name=info_name]').val(),
                                tel:$('#info_form').find('[name=info_tel]').val(),
                                province:$('#info_form').find('[name=info_province]').val(),
                                city:$('#info_form').find('[name=info_city]').val(),
                                region:$('#info_form').find('[name=info_region]').val(),
                                addr_detail:$('#info_form').find('[name=info_addr_detail]').val(),
                                is_default:isDefault
                            },
                            success:function(){
                                if(isDefault&&id){
                                    myAlert({
                                        mode:1,
                                        title:'设定成功',
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
                                        title:'保存成功',
                                        btn1:' 确 定',
                                        close:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"oderConfirm"
                                            });
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"oderConfirm"
                                            });
                                            ele.remove()
                                        }
                                    });
                                }
                                isSubmit=false;


                            },
                            error:function(){
                                isSubmit=false;
                                myAlert({
                                    mode:1,
                                    title:'提交失败',
                                    content:'请稍后再试',
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

            if(id){
                $('#delete').click(function(){
                    $.ajax({
                        type:'post',
                        url:'/customer/delete_delivery/'+id,
                        success:function(data){
                            if(!data.error){
                                myAlert({
                                    mode:1,
                                    title:'删除成功',
                                    btn1:' 确 定',
                                    close:function(ele){
                                        location.href = self.setupHashParameters({
                                            "view":"oderConfirm"
                                        });
                                        ele.remove()
                                    },
                                    btnClick:function(ele){
                                        location.href = self.setupHashParameters({
                                            "view":"oderConfirm"
                                        });
                                        ele.remove()
                                    }
                                });
                            }else{
                                myAlert({
                                    mode:1,
                                    title:'删除失败',
                                    btn1:' 确 定',
                                    close:function(ele){
                                        ele.remove()
                                    },
                                    btnClick:function(ele){
                                        ele.remove()
                                    }
                                });
                            }
                        },
                        error:function(){
                            myAlert({
                                mode:1,
                                title:'删除失败',
                                content:'请稍后再试',
                                btn1:' 确 定',
                                close:function(ele){
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    ele.remove()
                                }
                            });
                        }
                    })
                });
                $('#submit').click(function(){
                    isDefault=0;
                    $('#info_form').submit()
                });
            }else{
                $('.product_foot').hide();
                $('#set_default').text('确认提交')
            }

            $('#set_default').click(function(){
                isDefault=1;
                $('#info_form').submit()
            });



            router.background1();
            if(!id){
                router.addHead('新建地址')
            }else{
                router.addHead('编辑地址')
            }
        })
    },
    addressList:function(){
        var self = this;
        router.body.load('/customer/list_delivery',function(){
            $('#submit').click(function(){
                location.href = self.setupHashParameters({
                    "view":"addAddress",
                    "id":0
                });
            });
            $('.address_list li').click(function(){
                var id=$(this).attr('delivery_id');
                location.href = self.setupHashParameters({
                    "view":"addAddress",
                    "id":id
                });
            });
            router.background1();
            if(id){
                router.addHead('编辑地址')
            }else{
                router.addHead('选择地址')
            }
        })
    },
    /****************************选择规格******************************/
    chooseSize:function(id,type){
        var self = this;
        if(router.body.find('#size_box').length==0){
            router.body.append('<div id="size_box"></div>')
        }
        $('#size_box').load('/product/get_product_specification/'+id,function(){
            $('.confirm_box').show();
            $('.choose_size div:eq(0)').click();
            $('#close').click(function(){
                $('#confirm').hide()
            });

            $('.detail_btns .detail_btn').click(function(){
                $('#form').attr('action','http://www.baidu.com');
                $('#confirm').show()
            });

            $('.plus').click(function(){
                $(this).siblings('.count').text(parseInt($(this).siblings('.count').text())+1);
                $('#count').val(parseInt($(this).siblings('.count').text())+1);
                $('#total_score').text(parseInt($(this).siblings('.count').text())*$('.choose_size .chosen_size').attr('score'));
            });
            $('.reduce').click(function(){
                if(parseInt($(this).siblings('.count').text())>1){
                    $(this).siblings('.count').text(parseInt($(this).siblings('.count').text())-1);
                    $('#count').val(parseInt($(this).siblings('.count').text())-1);
                    $('#total_score').text(parseInt($(this).siblings('.count').text())*$('.choose_size .chosen_size').attr('score'));
                }
            });

            $('#total_score').text(parseInt($('.count').text())*$('.choose_size .chosen_size').attr('score'));

            var isSubmit=false;
            $('#submit').click(function(){
                var data={
                    id:id,
                    size:$('.choose_size .chosen_size').attr('size'),
                    spec_id:$('.choose_size .chosen_size').attr('spec_id'),
                    count:$('.confirm_count p').text(),
                    score:$('.choose_size .chosen_size').attr('score'),
                    name:$('.confirm_main>h1').text(),
                    credit:$('.choose_size .chosen_size').attr('score')*$('.confirm_count p').text(),
                    img:$('.confirm_main h1').attr('product_image')
                };
                if(isSubmit){
                    return
                }
                isSubmit=true;
                switch (parseInt(type)){
                    case 1:
                        $.ajax({
                            type:'post',
                            url:'/order_online/add_cart',
                            data:data,
                            dataType:'json',
                            success:function(data){
                                if(data){
                                    myAlert({
                                        mode:2,
                                        title:'添加成功',
                                        btn1:'进入购物车',
                                        btn2:'返回首页',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"cart"
                                            });
                                            ele.remove()
                                        },
                                        btnClick2:function(ele){
                                            location.href = self.setupHashParameters({
                                                "view":"index"
                                            });
                                            ele.remove()
                                        }
                                    });
                                }else{
                                    myAlert({
                                        mode:1,
                                        title:'加入购物车失败',
                                        btn1:' 确 定',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            ele.remove()
                                        }
                                    });
                                }
                                isSubmit=false
                            },
                            error:function(){
                                myAlert({
                                    mode:1,
                                    title:'加入购物车失败',
                                    content:'请稍后再试',
                                    btn1:' 确 定',
                                    close:function(ele){
                                        ele.remove()
                                    },
                                    btnClick:function(ele){
                                        ele.remove()
                                    }
                                });
                                isSubmit=false;
                            }
                        })
                        break;
                    case 2:
                        $.ajax({
                            type:'post',
                            url:'/customer/score',
                            dataType:'json',
                            success:function(newData){
                                console.log(newData);
                                if(parseInt(data.credit)>parseInt(newData)){
                                    myAlert({
                                        mode:1,
                                        title:'已超过最大积分（'+newData+'）',
                                        btn1:' 确 定',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            ele.remove()
                                        }
                                    });
                                }else{

                                    self.tempProduct=[data];
                                    location.href = self.setupHashParameters({
                                        "view":"oderConfirm"
                                    });

                                }
                                isSubmit=false;
                            },
                            error:function(){
                                myAlert({
                                    mode:1,
                                    title:'立即兑换失败',
                                    content:'请稍后再试',
                                    btn1:' 确 定',
                                    close:function(ele){
                                        ele.remove()
                                    },
                                    btnClick:function(ele){
                                        ele.remove()
                                    }
                                });
                                isSubmit=false
                            }
                        })
                        break
                }

            })
        })
    },
    /****************************产品详情******************************/
    productDetail:function(id,size){
        var self = this;
        router.body.load('/product/get_product_view/'+id+'/'+size,function(){
            $('.join_cart').click(function(){
                router.chooseSize(id,1)
            });
            $('.change_now').click(function(){
                router.chooseSize(id,2)
            });
            router.background1();
            router.addHead('商品详情')

        })
    }

}

router.initialize()