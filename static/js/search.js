$(function () {
    // 搜索
   $('.search-item').click(function () {
        var text = $('input[name="q"]').val();
        if(text == ''){
            layer.msg('请输入搜索关键词');
            return false;
        }
        window.location.href=$(this).attr('href')+text;
        return false;
    });
   // 时间选择
    $('.form_datetime').datetimepicker({
        language:  'zh-CN',
        startDate:new Date('January 1 2019'),
        endDate:new Date(),
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    // 带时间的搜索
    $('#s-t-a').click(function () {
        var text = $('input[name="q"]').val();
        if(text == ''){
            layer.msg('请输入搜索关键词');
            return false;
        }
        var startText = $('#start-time').val();
        var endText = $('#end-time').val();
        if(startText == '' || endText == ''){
            layer.msg('请选择日期');
            return false;
        }
        var start = new Date(startText).valueOf();
        var end = new Date(endText).valueOf();
        if((start-end)>0){
            layer.msg('结束时间不得早于开始时间');
            return false;
        }
        window.location.href=$('#article').attr('href')
            +text+'&start='+start/1000+'&end='+end/1000;
    });
});