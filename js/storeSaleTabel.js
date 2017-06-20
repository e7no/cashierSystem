/*
* @description: 门店销售明细js
* @author: will
* @update: will (2017-02-24 17:30)
* @version: v1.0
*/
$(function() {
	$('#example-getting-started').multiselect({
	    nonSelectedText: '请选择...',
	    maxHeight: 200,
	});
	$(".layui-btn-primary").click(function(){
		$("span.multiselect-selected-text").html("请选择...");
		$("ul.multiselect-container li").removeClass("active");
		$("button.multiselect").attr("title","");
	})
});