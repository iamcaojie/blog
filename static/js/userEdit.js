$.ajax({
    type: "get",
    url: "/static/img/bqb/emoji.json",
    dataType: "json",
    async: false,
    success: function (data) {
        emojiData = data;
    }
});
console.log(emojiData);
// 初始化wangEditor
var E = window.wangEditor;
var editor = new E('#editor');
editor.customConfig.uploadImgServer = '/admin/Upload/detail';
editor.customConfig.emotions = emojiData;
editor.customConfig.uploadImgHooks = {
    before: function (xhr, editor, files) {},
    // 图片上传并返回结果，图片插入成功之后触发
    success: function (xhr, editor, result) {},
    // 图片上传并返回结果，但图片插入错误时触发
    fail: function (xhr, editor, result) {
        layer.msg('图片载入失败');
    },
    // 图片上传出错时触发
    error: function (xhr, editor) {
        layer.msg('图片上传失败');
    },
    // 图片上传超时时触发
    timeout: function (xhr, editor) {
        layer.msg('图片上传超时');
    }
};
editor.create();
var masterImage = $('input[name="master_image"]');
$(function(){
    //上传主图
    var $masterUpload = $('#masterUpload').diyUpload({
        url:'/admin/Upload/master',
        success:function( data ) {
            layer.msg(data.msg);
            // 把图片id加到input中
            masterImage.val(masterImage.val() + data['data'][0]['id'] + ',');
        },
        error:function( err ) {
            layer.msg('上传失败');
        },
        buttonText : '',
        accept: {
            title: "Images",
            extensions: 'gif,jpg,jpeg,bmp,png'
        },
        thumb:{
            width:120,
            height:90,
            quality:100,
            allowMagnify:true,
            crop:true,
            type:"image/jpeg"
        }
    });
    $("#master-upload-btn").click(function () {
        $masterUpload.upload();
    });
});

$(function () {
    // 修改个性标签中的"，"和连续的·",,"
    var reg1 = new RegExp( '，' , "g" );
    var reg2 = new RegExp( ',+' , "g" );
    $("input[name='unique_tag']").on('keyup',function () {
       $(this).val($(this).val().replace( reg1 , ',' ));
       $(this).val($(this).val().replace( reg2 , ',' ));
    });
    // 清除主图
    $("#clear-upload-btn").click(function() {
        $("input[name='master_image']").val("");
        $("#master-image-box").remove();
        layer.msg('主图已清除，已上传主图不会显示');
    });
    // 同步编辑器中的内容
    $(".w-e-text").on('keyup click mouseleave focus',function(){
        $("input[name='edit-html']").val(editor.txt.html());
        $("input[name='edit-text']").val(editor.txt.text());
    });
    // 表单验证
    $("form").submit(function () {
        if(!check()){
            return false;
        }
        return true;
    });
});

// 检查
function check() {
    if(editor.txt.text() == ""){
        layer.msg('请输入内容');
        return false;
    }
    return true;
}