/*
* @description: 代金券列表js
* @author: will
* @update: will (2017-02-25 09:10)
* @version: v1.0
*/
$(function(){
	/*弹出新增代金券*/
	$('.new-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "新增代金券",//标题
			area: ['400px', '315px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".new-open"),//也可将html写在此处
		});
	});
	/*弹出历史代金券*/
	$('.history-btn').on('click', function(){
		layer.open({
			type: 2,
			title: '历史代金券',
			shadeClose: true,
			shade: 0.8,
			area: ['100%', '100%'],
		 	content: 'historyVoucher.html' //iframe的url
		});
	});
	/*开关*/
	layui.use('form', function(){
	  var form = layui.form();
	});
})
