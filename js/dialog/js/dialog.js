/*
 弹出提示框
 conent 内容
 btn 按钮名称
 fun 回调函数
 */
function Dialog(conent, btn, fun) {
    $(".mModal").remove();
    $(".mDialog").remove();
    var html = new Array();
    html.push("<div class=\"mModal\" style=\"z-index: 99999;\"><a href=\"javascript:void(0)\"></a></div>");
    html.push("<div class=\"mDialog\" style=\"z-index: 99999;\">");
    html.push("    <h2>" + conent + "</h2>");
    if (btn.length > 0) {
        html.push("    <footer><a class=\"one\" href=\"javascript:void(0)\">" + btn + "</a></footer>");
        html.push("    <a class=\"x\" href=\"javascript:void(0)\">X</a>");
    }
    html.push("</div>");
    $("body").append(html.join(""));
    var d = window.innerWidth, b = window.innerHeight, c = $(".mDialog").innerWidth(), h = $(".mDialog").innerHeight(), top = (0.5 * (b - h)) + "px", left = 0.5 * (d - c) + "px";
    $(".mModal a").css("height", b);
    $(".mDialog").css({'top': top, 'left': left});
    $(".one").off().on("click", function () {
        $(".mModal").remove();
        $(".mDialog").remove();
        if (fun != null) {
            $(fun).iCheck('uncheck');
        }
    });
    $(".x").off().on("click", function () {
        $(".mModal").remove();
        $(".mDialog").remove();
        if (fun != null) {
            $(fun).iCheck('uncheck');
        }
    });
}

// 显示正在加载...
function LoadDialog(loadtips) {
    var tips = "加载中";
    if (loadtips != "" && loadtips != undefined)
        tips = loadtips;
    $("#mLoading").remove();
    var html = new Array();

    html.push("<div id=\"mLoading\" ><div class=\"lbk\"></div><div class=\"lcont\">" + tips + "</div></div>");
    $("body").append(html.join(""));
    var d = window.innerWidth, b = window.innerHeight, c = $("#mLoading").innerWidth(), h = $("#mLoading").innerHeight(), top = (0.5 * (b - h)) + "px", left = 0.5 * (d - c) + "px";

    $("#mLoading").css({'top': top, 'left': left});
}

//移除正在加载...
function RemoveLoadDialog() {
    $("#mLoading").remove();
    $(".mModal").remove();
}
//===========================================================
function pop_alert(title, conent, btn) {
    var html = new Array();
    html.push("<div class=\"mModal\" style=\"z-index: 99999;\"><a href=\"javascript:void(0)\"></a></div>");
    html.push("<div class=\"pop_dialog\">");
    html.push("<h1>" + title + "</h1>");
    html.push("<div class=\"pop_dialog_content\">");
    html.push(conent);
    html.push("</div>");
    html.push("<div class=\"btn\">");
    html.push("<input type=\"button\" class=\"btn_ok\" value=\"" + btn + "\" style=\"width: 100%;\" />");
    html.push("</div>");
    html.push("</div>");
    $("body").append(html.join(""));
    var d = window.innerWidth, b = window.innerHeight, c = $(".pop_dialog").innerWidth(), h = $(".pop_dialog").innerHeight(), top = (0.5 * (b - h)) + "px", left = 0.5 * (d - c) + "px";
    $(".pop_dialog").css({'top': top, 'left': left});
    $(".mModal a").css("height", b);
    $(".btn_ok").off().on("click", function () {
        $(".pop_dialog").remove();
        $(".mModal").remove();
    });
}

function pop_alert2(title, img_url, btn) {
    var html = new Array();
    html.push("<div class=\"mModal\" style=\"z-index: 99999;\"><a href=\"javascript:void(0)\"></a></div>");
    html.push("<div class=\"pop_dialog\">");
    html.push("<h1>" + title + "</h1>");
    html.push("<div class=\"pop_dialog_content\">");
    html.push("<img src=\"" + img_url + "\"  height=\"100%\" width=\"100%\"/>");
    html.push("</div>");
    html.push("<div class=\"btn\">");
    html.push("<input type=\"button\" class=\"btn_ok\" value=\"" + btn + "\" style=\"width: 100%;\" />");
    html.push("</div>");
    html.push("</div>");
    $("body").append(html.join(""));
    var d = window.innerWidth, b = window.innerHeight, c = $(".pop_dialog").innerWidth(), h = $(".pop_dialog").innerHeight(), top = (0.5 * (b - h)) + "px", left = 0.5 * (d - c) + "px";
    $(".pop_dialog").css({'top': top, 'left': left});
    $(".mModal a").css("height", b);
    $(".btn_ok").off().on("click", function () {
        $(".pop_dialog").remove();
        $(".mModal").remove();
    });
}

function pop_confirm(title, conent, btn, fun) {
    //alert(title);

    var html = new Array();
    html.push("<div class=\"mModal\" style=\"z-index: 99999;\"><a href=\"javascript:void(0)\"></a></div>");
    html.push("<div class=\"pop_dialog\">");
    html.push("<h1>" + title + "</h1>");
    html.push("<div class=\"pop_dialog_content\">");
    html.push(conent);
    html.push("</div>");
    html.push("<div class=\"btn\">");
    html.push("<input type=\"button\" class=\"btn_ok\" value=\"" + btn + "\" style=\"width: 70%; float: left;\" />");
    html.push("<input type=\"button\" class=\"btn_cancel\" value=\"取消\" style=\"width: 27%;float: right;\" />");
    html.push("</div>");
    html.push("</div>");
    $("body").append(html.join(""));
    var d = window.innerWidth, b = window.innerHeight, c = $(".pop_dialog").innerWidth(), h = $(".pop_dialog").innerHeight(), top = (0.5 * (b - h)) + "px", left = 0.5 * (d - c) + "px";
    $(".mModal a").css("height", b);
    $(".pop_dialog").css({'top': top, 'left': left});
    $(".btn_ok").off().on("click", function () {
        $(".pop_dialog").remove();
        $(".mModal").remove();
        if (fun != null) {
            $(fun).iCheck('uncheck');
        }
    });
    $(".btn_cancel").off().on("click", function () {
        $(".pop_dialog").remove();
        $(".mModal").remove();
    });
}