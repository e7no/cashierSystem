
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
        strHtml += '<span title="第一页">&#171;</span>';
        strHtml += '<span title="上一页">&#139;</span>';
    } else {
        strHtml += '<span title="第一页"><a href="javascript:toPage(1);">&#171;</a></span>';
        strHtml += '<span title="上一页"><a href="javascript:toPage(' + prevPage + ');">&#139;</a></span>';
    }
    if (pageindex % 10 == 0) {
        var startPage = pageindex - 9;
    } else {
        var startPage = pageindex - pageindex % 10 + 1;
    }
    if (startPage > 10) strHtml += '<span title="上'+pagesize+'页"><a href="javascript:toPage(' + (startPage - 1) + ');">...</a></span>';
    for (var i = startPage; i < startPage + 10; i++) {
        if (i > pagecount) break;
        if (i == pageindex) {
            strHtml += '<span title="页 ' + i + '" class="selected">' + i + '</span>';
        } else {
            strHtml += '<span title="页 ' + i + '"><a href="javascript:toPage(' + i + ');">' + i + '</a></span>';
        }
    }
    if (pagecount >= startPage + 10) strHtml += '<span title="下'+pagesize+'页"><a href="javascript:toPage(' + (startPage + 10) + ');">...</a></span>';
    if (nextPage > pagecount) {
        strHtml += '<span title="下一页">&#155;</span>';
        strHtml += '<span title="最后一页">&#187;</span>';
    } else {
        strHtml += '<span title="下一页"><a href="javascript:toPage(' + nextPage + ');">&#155;</a></span>';
        strHtml += '<span title="最后一页"><a href="javascript:toPage(' + pagecount + ');">&#187;</a></span>';
    }
    strHtml += '</span>';
    strHtml += '</div>';
    return strHtml;
}
toPage = function (currentpage) { //页面跳转
    pageindex = currentpage;
    databindcallback();
    
}



//////////////////////////////////////ajax数据绑定

//function pager_initlist() {
//    pageindex = 1;
//    bindlist();
//}
//function bindlist() {
//	pageindex++;
//    $("#list").html("");
//    var name_val = $.trim($("#displayname").val());
//    var data = { ajaxmethod: "bindlist", pageindex: pageindex, pagesize: pagesize, displayname: name_val };
//    var url = "select_member.aspx";
//    get_ajax_pager(data, url, pager_addrows);
//}
////绑定行
//function pager_addrows(jsons) {
//    var json = jsons.data;
//    //alert(json.length);
//    if (json.length > 0) {
//        var results = "";
//        for (var i = 0; i < json.length; i++) {
//            results = '<div class="select_data_item">' +
//                '<div class="select_data_text">' + json[i].displayname + '</div>' +
//                '<div class="select_data_input">' +
//                '<input id="radio_' + json[i].uid + '" name="m_radio" type="radio" value="' + json[i].uid + '" onclick="select_item(\'' + json[i].uid + '\', \'' + json[i].displayname + '\');"/>' +
//                '</div>' +
//                '<div style="clear:both;"></div>' +
//                '</div>';
//            $("#list").append(results);
//        }
//    }
//    showPages('pagination', totalrows, pagesize, bindlist);
//}
//
//请求的参数
//请求地址/
//成功以后要执行的方法
//失败以后要执行的方法
function get_ajax_pager(ajaxdata, requseturl, success_callback, error_callback) {
    $.ajax({
        type: "post",
        url: requseturl,
        //dataType: "json",
        data: ajaxdata,
        beforeSend: function () {
            //$("#loading").attr('disabled', "disabled").html("加载中...");
        },
        success: function (data) {
			//alert(data);
			var results = eval("("+data+")");//转换为json对象
            totalrows = results.rowCount;
            //alert(totalrows);
            //pager_addrows(results.rows);
            success_callback(results);

            //$('#loading').html("加载更多");
            //$('#loading').removeAttr("disabled");

            //if (results.rows.length == 0) {
            //    $('#loading').attr('disabled', "disabled");
            //    $('#loading').html("无更多数据");
            //    pindex--;
            //}

            var mo = totalrows / pagesize;
            pagecount = parseInt(mo);

            if ((totalrows % pagesize) > 0) {
                pagecount = pagecount + 1;
            }
            //alert("totalrows=" + totalrows);
            if (pageindex > pagecount)
                pageindex = pagecount;

            if (pageindex <= 0)
                pageindex = 1;
            //alert(pindex);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("XMLHttpRequest.status="+XMLHttpRequest.status+" XMLHttpRequest.readyState="+XMLHttpRequest.readyState+" textStatus="+textStatus+" errorThrown="+errorThrown);
            //$('#loading').html("加载更多");
            //$('#loading').removeAttr("disabled");
            pageindex--;
        },
		complete: function(){}
    });
}