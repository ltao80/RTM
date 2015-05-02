
var url=window.location.href.split('/');
var openId=url[url.length-1];

var router={
    wrapper:$('#wrapper'),
    header:$('#header'),
    body:$('#main'),
    initialize:function(){
        $('#nav_menu_close').click(this.index);
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
        var html=$('<div class="header"><a href="javascript:void(0)" id="nav_menu_open"></a><p>'+title+'</p><img src="/static/images/logo.png" id="logo" /></div>');
        html.find('#logo').click(this.index);
        this.header.empty();
        this.header.html(html)
    },
    hideNav:function(){
        this.header.find('#nav_menu_open').hide()
    },
    /****************************主 页*****************************/
    index:function(){
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
                router.productDetail(id,parseInt($('#detail_size').attr('extra-data')))
            });
            router.background2();
            $('.home_button').click(function(){
                var id=$(this).attr('extra-data');
                router.chooseSize(id)
            })
        })

    },
    /****************************菜单四项*****************************/
    cart:function(){
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
                    url:'/order_line/add_cart',
                    data:{
                      data:allData
                    },
                    success:function(data){
                        if(data){
                            router.oderConfirm(data);
                            going.remove()
                        }else{
                            myAlert({
                                mode:1,
                                title:'提交失败',
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
                    },
                    error:function(){
                        router.oderConfirm(1);going.remove();return;
                        myAlert({
                            mode:1,
                            title:'提交失败',
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
            $('.query_list li').each(function(){
                $(this).find('.detail_btn').click(function(){
                    var id=$(this).attr('extra-data');
                    router.queryDetail(id)
                })
            });
            router.background1();
            router.addHead('积分查询')
        })
    },
    oderList:function(){
        router.body.load('../../views/shopping/oders-list.html',function(){
            $('.oders_list li').each(function(){
                $(this).find('.detail_btn').click(function(){
                    var id=$(this).attr('extra-data');
                    router.oderDetail(id)
                })
            });
            router.background1();
            router.addHead('积分订单')
        })
    },
    personalInfo:function(){
        router.body.load('/customer/get/'+openId,function(){
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
                                province:$('#info_form').find('[name=info_province]').val(),
                                city:$('#info_form').find('[name=info_city]').val(),
                                region:$('#info_form').find('[name=info_region]').val(),
                                address:$('#info_form').find('[name=info_addr_detail]').val(),
                                birthday:$('#info_form').find('[name=info_birthday]').val()
                            },
                            success:function(){
                                isSubmit=false;
                                going.remove();
                                myAlert({
                                    mode:1,
                                    title:'提交成功',
                                    content:'',
                                    btn1:' 确 定',
                                    close:function(ele){
                                        ele.remove();
                                        router.personalInfo()
                                    },
                                    btnClick:function(ele){
                                        ele.remove();
                                        router.personalInfo()
                                    }
                                });
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
            });
            router.background1();
            router.addHead('个人信息')
        })
    },
    /**************************积分查询订单详细页,订单确认页*****************************/
    queryDetail:function(id){
        router.body.load('../../views/shopping/query-detail.html?id='+id,function(){
            router.background1();
            router.addHead('积分查询')
        })
    },
    oderDetail:function(id){
        router.body.load('../../views/shopping/oders-detail.html?id='+id,function(){
            router.background1();
            router.addHead('积分订单')
        })
    },
    oderConfirm:function(id){
        router.body.load('/order_online/confirm?id='+id,function(){
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
                        $.ajax({
                            type:'post',
                            url:'/',
                            data:{
                                message:$('#addr_form').find('[name=message]').val(),
                                addr:$('#addr_form').find('[name=address]').val()
                            },
                            success:function(){
                                isSubmit=false;
                                myAlert({
                                    mode:2,
                                    title:'兑换成功',
                                    content:'请稍后再试',
                                    btn1:'继续兑换',
                                    btn2:'查看订单',
                                    close:function(ele){
                                        ele.remove()
                                    },
                                    btnClick:function(ele){
                                        router.cart();
                                        ele.remove()
                                    },
                                    btnClick2:function(ele){
                                        router.oderList();
                                        ele.remove()
                                    }
                                });
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
            $('#select_address').click(function(){
                router.addressList(id)
            });
            router.background1();
            router.addHead('订单确认')
        })
    },
    /****************************新建,选择地址******************************/
    addAddress:function(){
        router.body.load('../../views/shopping/add-address.html',function(){
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
                            url:'/',
                            data:{
                                name:$('#info_form').find('[name=info_name]').val(),
                                tel:$('#info_form').find('[name=info_tel]').val(),
                                addr:$('#info_form').find('[name=info_addr]').val(),
                                addr_detail:$('#info_form').find('[name=info_addr_detail]').val()
                            },
                            success:function(){
                                isSubmit=false;
                                router.oderConfirm(1)
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
            router.background1();
            router.addHead('新建地址')
        })
    },
    addressList:function(id){
        router.body.load('../../views/shopping/address-list.html?id='+id,function(){
            $('#submit').click(router.addAddress);
            router.background1();
            router.addHead('选择地址')
        })
    },
    /****************************选择规格******************************/
    chooseSize:function(id){
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
                $('#count').val(parseInt($(this).siblings('.count').text())+1)
            });
            $('.reduce').click(function(){
                if(parseInt($(this).siblings('.count').text())>1){
                    $(this).siblings('.count').text(parseInt($(this).siblings('.count').text())-1);
                    $('#count').val(parseInt($(this).siblings('.count').text())-1)
                }
            });

            var isSubmit=false;
            $('#submit').click(function(){
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
                    url:'/order_online/add_cart',
                    data:{
                        data:{
                            id:id,
                            size:$('.choose_size .chosen_size').text(),
                            count:$('.confirm_count p').text()
                        }
                    },
                    success:function(data){
                        if(data){
                            router.oderConfirm(data);
                            going.remove()
                        }else{
                            myAlert({
                                mode:1,
                                title:'提交失败',
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
                    },
                    error:function(){
                        router.oderConfirm(1);going.remove();return;
                        myAlert({
                            mode:1,
                            title:'提交失败',
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

            })
        })
    },
    /****************************产品详情******************************/
    productDetail:function(id,size){
        router.body.load('/product/get_product_view/'+id+'/'+size,function(){
            $('.join_cart').click(function(){
                router.chooseSize(id)
            });
            $('.change_now').click(function(){
                router.chooseSize(id)
            });
            router.background1();
            router.addHead('商品详情')

        })
    }

}

router.initialize()