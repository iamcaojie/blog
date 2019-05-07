var eQrcode = $("#qrcode"),
    commentText = $('#comment_text'),
    textCount = $('#text-count'),
    maxCount = 500,
    commentBox = $('#show-comment-box');


$(function(){ 
    //评论列表-回复切换
    $("#comment-tab li").click(function(){
        $(this).addClass("selected").siblings().removeClass("selected");
        var index = $(this).index();
        $('#comment-tab-detail').children().eq(index).show().siblings().hide();
    });
    // 二维码显示
    $("#s-qrcode").hover(function(){
        eQrcode.toggle();
    });
    // 显示回复详情
    $(".display-reply").click(function () {
        if($(this).text() === '显示回复详情'){
            $(this).text('隐藏回复详情');
            $(this).parent().parent().parent().find(".reply-box").show();
        }else if($(this).text() === '隐藏回复详情'){
            $(this).text('显示回复详情');
            $(this).parent().parent().parent().find(".reply-box").hide();
        }
    });
    // 回复评论
    $(".reply-comment").click(function(){
        if(!isLogin()){
            getLogin();
            layer.msg('请登录后回复');
            return false;
        }
        $(this).parent().parent().parent().find(".reply-input").show();
        $(this).parent().parent().hide();
    });
    // 显示评论控制
    $(".display-reply-control").click(function() {
        $(this).parent().hide();
        $(this).parent().parent().find('.reply-control').show();
    });
    // 提交回复
    $(".reply-btn").click(function() {
        if(!isLogin()){
            getLogin();
            layer.msg('请登录后回复');
            return false;
        }
        var commentId = $(this).prevAll().eq(1).val();
        var replyText = $(this).prevAll().eq(0).val();
        if(replyText === ""){
            layer.msg('请输入回复');
            return false;
        }
        var info = postReply('/blog/detail/replyComment','POST',{'comment_id':commentId,'reply_text':replyText});
        var replyData = info.data;
        if(info.status === 0) {
            $(this).parent().parent().find('.reply-box').append('<div class="reply-content"><a href="/user?id='+replyData['user_id']+'"><span class="nickname">'
                +replyData['nickname']+'</span></a><span class="time">'
                +replyData['create_time']+'</span><div class="reply-text">'
                +replyData['reply_text']+'</div></div>');
        }
        $(this).parent().hide();
        $(this).parent().parent().find('.reply-control').show();
        $(this).parent().parent().find('.display-reply').text('显示回复详情');
        $(this).prevAll().eq(0).val('');
    });
    // 清空评论
    $("#clear").click(function(){
        commentText.val("");
        return false;
    });
    $("#comment_text").on('keyup click mouseleave',function(){
        checkComment();
        makeHtml();
    });

    // 提交评论
    $("#submit").click(function(){
        if(postCheck()){
            var data = {"blog_id":$('input[name="id"]').val(),"comment_text":commentText.val()};
            postComment('/blog/detail/comment','POST',data);
        }
        return false;
    });
});

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

// 预览评论
function makeHtml() {
    var converter = new showdown.Converter();
    var text = commentText.val();
    var html = converter.makeHtml(text);
    commentBox.html(html);
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
                //清空评论
                $("#comment_text").val("");
                // 把评论添加到页面中
                var commentData = data.data[0];
                $('#comment-list').append('<li><div class="comment-avatar"><a href="/user?id='+commentData['user_id']+'"> <img style="width:100%;border-radius: 50%;" src="'+commentData['commentUserImageUrl']+'"/>' +
                    '</a> </div><div class="comment-content"><div><a href="/user?id='+commentData['user_id']+'"><span class="nickname">'+commentData['nickname']+'</span></a><span class="time">'+commentData['create_time']+'</span' +
                    '></div> <div class="comment-text">'+commentData['comment_text']+'</div><div class="reply-control" style="clear: both;">' +
                    '<span style="float: right;display:inline-block;"><a class="reply-comment" href="javascript:void(0);">回复</a></span> ' +
                    '<span style="float: right;display:inline-block;margin-right: 10px;"><a href="javascript:void(0);">暂无回复</a></span> ' +
                    '</div><div class="reply-input"><input type="hidden" value="'+commentData['id']+'"/> ' +
                    '<input type="text"/> <botton class="reply-btn">回复</botton> <a class="display-reply-control" href="javascript:void(0);"><i class="fa fa-close" ></i></a' +
                    '> </div><div class="reply-box"> </div></div> <div class="divid-line"></div></li>');
            },error:function(data){
                layer.msg("评论失败");
            }
        });
    });
}

// 提交回复
function postReply(url,method,data){
    var info = {};
    $.ajax({
        type:method || 'POST',
        url:url,
        data:data,
        async:false,
        dataType:'json',
        success: function(data){
            layer.msg(data.msg);
            // 把回复添加到页面中
            info['status'] = data.code;
            info['data'] = data.data;
        },error:function(data){
            info['status'] = -1;
            layer.msg("评论失败");
        }
    });
    return info;
}

//生成网址二维码
function makeCode(){
    var qrcode = new QRCode("qrcode",{
        width: 128,
        height: 128,
        colorDark : "#333",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
    qrcode.makeCode(window.location.href);
}
makeCode();