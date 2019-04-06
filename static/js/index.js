///初始化layui
layui.use('carousel', function(){
var carousel = layui.carousel;
    carousel.render({
        elem: '#banner',
        width: '100%',
        height: reSizeBanner(),
        arrow: 'always',
        anim: 'fade',
        interval:'7000'
        // height: '400px'
    });
});

var timeoutId = setInterval(function() {
    console.log(Math.round(new Date().getTime()/1000));
}, 1000);

$(function(){
    $(window).resize(function() {
        $('#banner').css("height", reSizeBanner());
    });
    $("#check-in").click(function () {
        $(this).hide();
        $.get('/',function (data,status) {
            var msgData = '<p><i>  总有些惊奇的际遇<br>比方说当我遇见你！</i></p>';
            var year = (new Date()).getUTCFullYear();
            var month = (new Date()).getUTCMonth();
            var day = (new Date()).getUTCDate()+1;
            $("#check-in-box").append(msgData);
            // 设置cookie，当天24：00过期
            document.cookie = encodeURIComponent("msgData")
                + "="
                + encodeURIComponent(msgData)
                + ";path=/"
                + ";expires="
                + (new Date(Date.UTC(year,month,day,-8,0,0))).toUTCString();
        })
    });
});
// 重置banner高度
function reSizeBanner() {
    var windowWidth = $(window).width();
    if ( windowWidth > 1200) {return '350px'};
    if ( windowWidth >=990 && windowWidth <= 1200) {return '350px'};
    if ( windowWidth >=600 && windowWidth < 990) {return '360px'};
    if ( windowWidth < 600) {return '250px'};
}
// 音乐播放器对象
function MusicPlayer(box) {
    this._name = 'musicPlayer';
    // 初始化播放器
    this.init=function(){
        // 创建播放器元素
        var audio = document.createElement('audio');
        var prev = document.createElement('span');
        // 绑定事件

    };
    // 重设播放器名
    this.setName=function (newName) {
        this._name = newName;
    };
    this.changeModel=function () {
        
    }
};
var music = new MusicPlayer('q');