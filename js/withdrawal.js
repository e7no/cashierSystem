/*
* @description: 提现记录
* @author: will
* @update: will (2017-02-25 09:10)
* @version: v1.0
*/
$(function(){
	/*提现记录*/
	$('.record-btn').on('click', function(){
		layer.open({
			type: 2,
			title: "提现记录",//标题
			area: ['100%', '100%'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			offset: ['0', '0'],
			content: 'recordDrawal.html',
		});
	});
	
	layui.use('element', function(){
		var $ = layui.jquery,
		element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块
	})
})