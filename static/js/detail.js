//初始化layui
layui.use(['layer', 'form'], function(){
var layer = layui.layer
,form = layui.form;
});

$(function(){ 
//    评论列表-回复切换
    $("#comment-list-tab").click(function(){
        $(this).addClass("selected");
        $(this).siblings().removeClass("selected");
        $('#comment-list').show();
        $('#reply-comment').hide();
    });
    $("#reply-comment-tab").click(function(){
        $(this).addClass("selected");
        $(this).siblings().removeClass("selected");
        $('#comment-list').hide();
        $('#reply-comment').show();
    });
//    提交评论
    $("#submit").click(function(){
        alert("a");
        return false;
    });
});


// 检测登录状态
function checkLogin(){
    
}
// 检测评论内容，后台也需检测
function checkComment(){
// 字数统计
// 敏感词
// 黑客攻击词

}
// 提交评论
function postComment(){
    
}
console.log("欢迎提交bug或建议，联系方式QQ10804842")