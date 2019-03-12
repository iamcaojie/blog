//初始化layui
layui.use(['layer', 'form'], function(){
    var layer = layui.layer;
});

function  goPage() {
    var pageNum = $("input[name='go-page']").val();
    if(pageNum==""){
        layer.msg('请输入页码!!!');
        return false;
    }
    var pattern = /page=+[\s\S].*/i;
    var href = location.href.replace(pattern,"page=");
    var pageMax = $("input[name='page-max']").val();
    if(pageNum.match(/^[0-9]*$/i)){
        if(pageNum>pageMax){
            pageNum = pageMax;
        }
        location.assign(href+pageNum);
    }else{
        layer.msg('请输入数字！！！');
    }
    return false;
}