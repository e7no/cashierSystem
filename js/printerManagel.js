/*
* @description: 硬件管理js
* @author: will
* @update: will (2017-02-22 11:10)
* @version: v1.0
*/
$(function(){
	/*弹出编辑*/
	$('.news-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '添加硬件',
			area : ['100%' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'addPrinter.html',
		});
	});
	
	/*删除提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定删除选中的硬件设备吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	
	/*查看打印内容*/
	$('.view-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '打印内容',
			area : ['400px' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'printerContent.html',
		});
	});
});