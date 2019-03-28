layui.use(['layer'], function(){
    var layer = layui.layer
});

var  searchText= $('input[name="q"]');
$(function(){
    // 检查搜索框
    $("#search").click(function(){
        if ( searchText.val() == ""){
            layer.msg('请输入搜索内容！！！');
            return false;
        }
    });
    // 微信小程序
    $('#wechat').hover(function(){
        $('#wechat-box').show();
    });
    $('#wechat-box').hover(function(){
        $('#wechat-box').show();
    });
    // 留言
    $('#massage').click(function(){
        layer.open({
            type: 1,
            skin: 'massageboard-class',
            area: ['500px', '400px'],
            title: '<div style="color: rgb(176,58,91);"><b>有什么想说的，在这里畅所欲言^_^</b></div>',
            content: '<div id="massage-board"><form >留言主题\n\
            <br><input placeholder="必填，25字以内" name="massage_title"/>\n\
            <br>联系方式<br><input placeholder="选填，最多20字" name="contact"/>\n\
            <br>留言内容<br><textarea id="massage-text" placeholder="选填，最多200字" name="massage_text"></textarea></form><span id="text-count"></span></div>'
            ,btn: ['提交']
            ,yes: function(index, layero){
                postMassage();
                layer.close(index);
            }
        });
    });
});

// 检测留言内容，提交时后台也需检测
function checkMassage(){

}

// 提交留言
function postMassage(){
    $(function(){
        var massageTitle = $('input[name="massage_title"]'),
            contact = $('input[name="contact"]'),
            massageText = $('#massage-text');
        var massageData = {"massage_title":massageTitle.val(),"contact":contact.val(),"massage_text":massageText.val()};
        console.log(massageData);
        $.ajax({
            url:'/blog/index/getmassage',
            type:'POST',
            data:massageData,
            dataType: 'json',
            success:function(data){
                layer.msg(data.msg);
            },
            error:function(){
                layer.msg('提交失败');
                return false;
            }
        });
    });
}

// 检测是否为IE
function IEVersion() {
    //取得浏览器的userAgent字符串
    var userAgent = navigator.userAgent;
    //判断是否IE<11浏览器
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1;
    //判断是否IE的Edge浏览器
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE;
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if(isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if(fIEVersion == 7) {
            return 7;
        } else if(fIEVersion == 8) {
            return 8;
        } else if(fIEVersion == 9) {
            return 9;
        } else if(fIEVersion == 10) {
            return 10;
        } else {
            return 6;//IE版本<=7
        }
    } else if(isEdge) {
        return 'edge';//edge
    } else if(isIE11) {
        return 11; //IE11
    }else{
        return -1;//不是ie浏览器
    }
}
