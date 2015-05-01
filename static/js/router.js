

var router={
    wrapper:$('#wrapper'),
    header:$('#header'),
    body:$('#main'),
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
        var html=$('<div class="header"><a href="javascript:void(0)" id="nav_menu_open"></a><p>'+title+'</p><img src="images/logo.png" /></div>');
        this.header.empty();
        this.header.html(html)
    },
    hideNav:function(){
        this.header.find('#nav_menu_open').hide()
    },
    index:function(){
        this.body.load('../../application/views/home.html',function(){

        });
        this.body.find('.main_left li').click(function(){
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
        this.background2()
    },
    cart:function(){
        var html=$('')
    }
}

router.index()