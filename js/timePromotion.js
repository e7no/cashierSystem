/*
* @description: 时段促销js
* @author: will
* @update: will (2017-02-27 09:10)
* @version: v1.0
*/
$(function(){
	/*弹出新增分段折扣*/
	$('.new-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "分段折扣",//标题
			area: ['600px', '400px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".new-open"),//也可将html写在此处
		});
	});
	/*复选框*/
	layui.use('form', function(){
	  var form = layui.form();
	});
})