var pageindex = 1;//当前页数
var pagecount = 1;//总页数
var totalrows; //总条数
var pagesize = 10;//页显示条数
var databindcallback;

var pageshowid;
function showPages(showid, trows, pSize, callback) { //初始化属性

    totalrows = trows;
    pagesize = pSize;

    var mo = totalrows / pagesize;
    pagecount = parseInt(mo);
    //alert("totalrows=" + totalrows + " pagesize=" + pagesize + " " + totalrows % pagesize);
    if ((totalrows % pagesize) > 0) {
        pagecount = pagecount + 1;
    }

    if (pagecount <= 0)
        pagecount = 1;

    if (pageindex <= 0)
        pageindex = 1;

    pageshowid = showid;
    databindcallback = callback;
    document.getElementById(pageshowid).innerHTML = createHtml();
    //databindcallback();
}
function createHtml() { //生成html代码
    //alert("pagecount=" + pagecount);
    var strHtml = '', prevPage = pageindex - 1, nextPage = pageindex + 1;
    strHtml += '<div class="pages">';
    strHtml += '<span class="count">共 ' + totalrows + ' 条&nbsp;&nbsp;&nbsp;&nbsp;' + pageindex + ' / ' + pagecount + ' 页</span>';
    strHtml += '<span class="number">';
    if (prevPage < 1) {
        strHtml += '<span title="第一页">首页</span>';
        strHtml += '<span title="上一页">上一页</span>';
    } else {
        strHtml += '<a href="javascript:toPage(1);"><span title="第一页">首页</span></a>';
        strHtml += '<a href="javascript:toPage(' + prevPage + ');"><span title="上一页">上一页</span></a>';
    }
    if (pageindex % 10 == 0) {
        var startPage = pageindex - 9;
    } else {
        var startPage = pageindex - pageindex % 10 + 1;
    }
    if (startPage > 10) strHtml += '<a href="javascript:toPage(' + (startPage - 1) + ');"><span title="上' + pagesize + '页">...</span></a>';
    for (var i = startPage; i < startPage + 10; i++) {
        if (i > pagecount) break;
        if (i == pageindex) {
            strHtml += '<span title="页 ' + i + '" class="selected">' + i + '</span>';
        } else {
            strHtml += '<a href="javascript:toPage(' + i + ');"><span title="页 ' + i + '">' + i + '</span></a>';
        }
    }
    if (pagecount >= startPage + 10) strHtml += '<a href="javascript:toPage(' + (startPage + 10) + ');"><span title="下' + pagesize + '页">...</span></a>';
    if (nextPage > pagecount) {
        strHtml += '<span title="下一页">下一页</span>';
        strHtml += '<span title="最后一页">尾页</span>';
    } else {
        strHtml += '<a href="javascript:toPage(' + nextPage + ');"><span title="下一页">下一页</span></a>';
        strHtml += '<a href="javascript:toPage(' + pagecount + ');"><span title="最后一页">尾页</span></a>';
    }
    strHtml += '</span>';
    strHtml += '</div>';
    $("#strong").html(totalrows);
    return strHtml;
}
toPage = function (currentpage) { //页面跳转
    pageindex = currentpage;
    databindcallback();

}
//请求的参数
//请求地址/
//成功以后要执行的方法
//失败以后要执行的方法
/*
 查询列表
 */
function get_ajax_pager(ajaxdata, requseturl, success_callback, error_callback) {
    $.ajax({
        type: "post",
        url: requseturl,
        //dataType: "json",
        data: {datas: ajaxdata},
        success: function (data) {
            if (data == null || data == "" || data == "null") {
                Huimodal_alert('服务端报错，数据为空', 2000);
                pageindex--;
            }
            var results = eval("(" + data + ")");//转换为json对象
            totalrows = results.datas.page.totalSize;
            success_callback(results);
            var mo = totalrows / pagesize;
            pagecount = parseInt(mo);
            if ((totalrows % pagesize) > 0) {
                pagecount = pagecount + 1;
            }
            if (pageindex > pagecount)
                pageindex = pagecount;
            if (pageindex <= 0)
                pageindex = 1;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //alert("XMLHttpRequest.status="+XMLHttpRequest.status+" XMLHttpRequest.readyState="+XMLHttpRequest.readyState+" textStatus="+textStatus+" errorThrown="+errorThrown);
            Huimodal_alert('服务端出错', 2000);
            pageindex--;
        },
        complete: function () {
        }
    });
}