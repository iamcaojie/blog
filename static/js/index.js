///初始化layui
layui.use('carousel', function(){
var carousel = layui.carousel;
    carousel.render({
        elem: '#banner',
        width: '100%',
        height: '350px',
        arrow: 'always',
        anim: 'fade',
        interval:'7000'
        // height: '400px'
    });
});

var timeoutId = setInterval(function() {
    console.log(Math.round(new Date().getTime()/1000));
}, 1000);
// $(function(){

// });

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