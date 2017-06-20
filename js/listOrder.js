/*
* @description: 购买记录js
* @author: will
* @update: will (2017-02-24 16:30)
* @version: v1.0
*/
$(function(){
	/*弹出订单详情*/
	$('.view-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "订单详情",//标题
			area: ['500px', '350px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".view-open"),//也可将html写在此处
		});
	});
})
