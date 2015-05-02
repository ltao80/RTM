/*function resetWindow(){
    $('#wrapper').height($('#wrapper').width()/0.625+'px')
}
resetWindow();
window.resize=resetWindow;*/

$('#nav_menu_open').live('click',function(e){
    e.stopPropagation();
    $('.nav_box').show()
});
$('#nav_menu_close').live('click',function(){
    $('.nav_box').hide()
});
/*$('.nav_box').click(function(e){
    e.stopPropagation()
});*/
$('body').click(function(){
    $('.nav_box').hide();
    $('.drop_down').removeClass('drop_down_open')
});

if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch){
    $('body')[0].addEventListener('touchstart',function(){
        $('.nav_box').hide()
    });
    $('.nav_box')[0].addEventListener('touchstart',function(e){
        e.stopPropagation()
    });
}

function isOk(){
    setTimeout(function(){
        $.ajax({
            type:'post',
            url:'/url',
            dataType:'json',
            success:function(data){
                if(!data){
                    isOk()
                }else{
                    window.location.href='http://newurl'
                }
            },
            error:function(){
                isOk()
            }
        })
    },3000)
}
//isOk();

function resetFontsize(){
    var w=window.screen.width;
    if(w<=640){
        $('html,body').css('font-size',62.5*800/w+'%')
    }else{
        $('html,body').css('font-size',100*800/w+'%')
    }
}
//resetFontsize()

function resetWindow(){
    document.getElementById('wrapper').style.height=document.body.clientWidth/0.64+'px'
}

function myAlert(option) {
    var ele = $('<div class="my_alert_box">' +
        '<div class="my_alert">' +
        '<div class="my_close">×</div>' +
        '<h1>' + option.title + '</h1>' +
        '<p>' + (option.content ? option.content : '') + '</p>' +
        '<div class="my_btns ' + (option.mode == 2 ? "two_btn" : "") +(option.mode == 0 ? " no_btn" : "")+ '">' +
        '<a href="javascript:void(0)" class="detail_btn" id="submit">' + (option.btn1?option.btn1:"确认") + '</a>' +
        (option.mode == 2 ? '<a href="javascript:void(0)" class="detail_btn" id="submit">' + option.btn2 + '</a>' : '') +
        '</div>' +
        '</div>' +
        '</div>');
    ele.find('.my_close').click(function () {
        option.close(ele)
    });
    ele.find('.my_btns a').eq(0).click(function () {
        option.btnClick(ele)
    });
    if (option.mode == 2){
        ele.find('.my_btns a').eq(1).click(function () {
            option.btnClick2(ele)
        })
    }
    $('body').find('.my_alert_box').remove();
    $('body').append(ele);
    return ele
}

$('.choose_size div').live('click',function(){
    $(this).addClass('chosen_size').siblings().removeClass('chosen_size')
});

$('form').live('submit',function(){
    return false
});

