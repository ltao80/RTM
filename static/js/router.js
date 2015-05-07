
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
        this.header.html(html);
        window.document.title=title?title:'积分商城'
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
            window.document.title='积分商城';
            $('.home_button').click(function(){
                var id=$(this).attr('extra-data');
                router.productDetail(id,parseInt($('#detail_size').attr('extra-data')))
                /*var id=$(this).attr('extra-data');
                router.chooseSize(id,2)*/
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
                router.oderConfirm(allData)
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
                            router.cart();
                            ele.remove()
                        },
                        btnClick:function(ele){
                            router.cart();
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
                    data:delData,
                    dataType:'json',
                    success:function(data){
                        if(data){
                            myAlert({
                                mode:1,
                                title:'删除成功',
                                btn1:' 确 定',
                                close:function(ele){
                                    router.cart();
                                    ele.remove()
                                },
                                btnClick:function(ele){
                                    router.cart();
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
        router.body.load('/score/score_list',function(){
            $('.query_list li').each(function(){
                $(this).find('.detail_btn').click(function(){
                    var id=$(this).attr('extra-data');
                    var order_code=$(this).attr('order_code');
                    var order_type=$(this).attr('order_type');
                    router.queryDetail(order_code,order_type);
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
                                birthday:$('#info_form').find('[name=info_birthday]').val(),
                                email:$('#info_form').find('[name=info_email]').val()
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
    queryDetail:function(order_code,order_type){
        router.body.load('/score/score_detail/'+order_code+'/'+order_type,function(){
            router.background1();
            router.addHead('积分查询')
        })
    },
    oderDetail:function(id){
        router.body.load('/order-online/order_detail/'+id,function(){
            router.background1();
            router.addHead('兑换记录')
        })
    },
    oderConfirm:function(data){
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
                $('#oders_main2_list').append(li)
                count=count+parseInt(item.count);
                score=score+parseInt(item.credit);
            });
            $('#count').text(count);
            $('#score').text(score);

            $('#new_address').click(function(){
                router.addAddress(data,0)
            });
            $('#select_address').click(function(){
                router.addressList(data)
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
                        $.ajax({
                            type:'post',
                            url:'/order_online/make',
                            data:{
                                message:$('#addr_form').find('[name=message]').val(),
                                delivery_id:$('#addr_form').find('[name=address]').val(),
                                product_list:data,
                                delivery_thirdparty_code:''
                            },
                            success:function(data){
                                isSubmit=false;
                                if(data){
                                    myAlert({
                                        mode:2,
                                        title:'兑换成功',
                                        btn1:'继续兑换',
                                        btn2:'查看订单',
                                        close:function(ele){
                                            ele.remove()
                                        },
                                        btnClick:function(ele){
                                            router.index();
                                            ele.remove()
                                        },
                                        btnClick2:function(ele){
                                            router.oderList();
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
            router.background1();
            router.addHead('订单确认')
        })
    },
    /****************************新建,选择地址******************************/
    addAddress:function(myData,id){
        id=id?id:0;
        router.body.load('/customer/index_delivery/'+id,function(){
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
                        isSubmit=true;
                        myAlert({
                            mode:2,
                            title:'是否设为默认地址',
                            btn1:'是',
                            btn2:'否',
                            close:function(ele){
                                ele.remove()
                            },
                            btnClick:function(ele){
                                myAjax(myData,1);
                                ele.remove()
                            },
                            btnClick2:function(ele){
                                myAjax(myData,0);
                                ele.remove()
                            }
                        });

                        function myAjax(myData,isDefault){console.log(JSON.stringify(myData));
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
                                    isSubmit=false;
                                    router.oderConfirm(myData)
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
                        }

                        return false
                    }
                }
            });
            router.background1();
            router.addHead('新建地址')
        })
    },
    addressList:function(data){
        router.body.load('/customer/list_delivery',function(){
            $('#submit').click(function(){
                router.addAddress(data,0)
            });
            $('.address_list li').click(function(){
                var id=$(this).attr('delivery_id');
                router.addAddress(data,id)
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
                switch (type){
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
                                            router.cart();
                                            ele.remove()
                                        },
                                        btnClick2:function(ele){
                                            router.index();
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
                                    router.oderConfirm([data])
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