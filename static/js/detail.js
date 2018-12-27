//初始化layui
layui.use(['layer', 'form'], function(){
var layer = layui.layer
,form = layui.form;
});

var commentText = $('#comment_text');
var textCount = $('#text-count');
var maxCount = 200;

$(function(){ 
//    评论列表-回复切换
    $("#comment-tab li").click(function(){
        $(this).addClass("selected").siblings().removeClass("selected");
        var index = $(this).index();
        $('#comment-tab-detail').children().eq(index).show().siblings().hide();
    });
//    清空评论
    $("#clear").click(function(){
        commentText.val("");
        return false;
    });
    $("#comment_text").on('keyup click mouseleave',function(){
        checkComment();
    });

//    提交评论
    $("#submit").click(function(){
        if(postCheck()){
            var data = {"blog_id":$('input[name="id"]').val(),"comment_text":commentText.val()};
            console.log(data);
            postComment('/blog/python/comment','POST',data);
        }
        return false;
    });
});

// 检测登录状态
function checkLogin(){
    
}
// 实时检测评论内容，后台也需检测
function checkComment(){
    var count = commentText.val().length;
    if (count <= maxCount){
        textCount.html(count + "/" + maxCount);
    }else{
        textCount.html(count + "/" + maxCount);
        layer.msg("评论已超过字数限制");
        commentText.val(commentText.val().substr(0,maxCount));
    }
}
    
function postCheck(){
    var count = commentText.val().length;
    if(count < 1){
        layer.msg("评论字数为0，请输入评论再提交");
        return false;
    }else if(count > maxCount){
        layer.msg("评论字数过多");
        return false;
    }else{
        return true;
}
// 敏感词
// 黑客攻击词
}
// 提交评论
function postComment(url,method,data){
    $(function(){ 
        $.ajax({
            type:method || 'POST',
            url:url,
            data:data,
            dataType:'json',
            success: function(data){
                layer.msg(data.msg);
                $('#comment_text').val("");
                
            },error:function(data){
                layer.msg("评论失败");
                
            }
        });
    });
}
//获取最新评论
function getNewComments(){
    
}
console.log("欢迎提交bug或建议，联系方式QQ10804842")