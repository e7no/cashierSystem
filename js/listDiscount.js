/*
* @description: 折扣列表js
* @author: will
* @update: will (2017-02-25 09:10)
* @version: v1.0
*/
$(function(){
	/*弹出新增折扣*/
	$('.new-btn').on('click', function(){
		layer.open({
			type: 2,
			title: "新增折扣",//标题
			area: ['632px', '100%'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			offset: ['0', '0'],
			content: 'detailsDiscount.html',
		});
	});
	/*删除选中打折项目提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定删除选中打折项目吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	/*关闭*/
	$(".close-btn").on("click", function(){
		layer.alert('亲，您确定关闭该打折项目吗？', {
			icon: 5,
			resize: false, //禁止拉伸
			title: "关闭",
		}, function(index){
			layer.msg('关闭成功！',{icon: 6,time:1000});
		});
	});
	/*启动*/
	$(".start-btn").on("click", function(){
		layer.alert('亲，您确定重新启用该打折项目吗？', {
			icon: 3,
			resize: false, //禁止拉伸
			title: "启用",
		}, function(index){
			layer.msg('启用成功！',{icon: 6,time:1000});
		});
	});
	/*弹出查看*/
	$('.view-btn').on('click', function(){
		layer.open({
			type: 2,
			title: "查看",//标题
			area: ['470px', '100%'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			offset: ['0', '0'],
			content: 'viewDiscount.html',
		});
	});
	/*弹出回收站*/
	$('.btn-delete').on('click', function(){
		layer.open({
		type: 2,
			title: '回收站',
			area : ['100%' , '100%'],
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'recycleListDiscount.html',
		});
	});
})
