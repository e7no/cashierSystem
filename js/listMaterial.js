/*
* @description: 原料列表js
* @author: will
* @update: will (2017-02-22 11:10)
* @version: v1.0
*/
$(function(){
	/*删除选中的商品提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定删除选中的原料吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	/*删除单一商品提示*/
	$(".goods-delbtn").on("click", function(){
		layer.alert('亲，您确定删除该原料吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	/*关闭选中的商品提示*/
	$(".xj-btn").on("click", function(){
		layer.alert('亲，您确定关闭选中的原料吗？', {
			icon: 5,
			resize: false, //禁止拉伸
			title: "下架",
		}, function(index){
			layer.msg('关闭成功！',{icon: 6,time:1000});
		});
	});
	/*关闭单一商品提示*/
	$(".txj-btn").on("click", function(){
		layer.alert('亲，您确定关闭该原料吗？', {
			icon: 5,
			resize: false, //禁止拉伸
			title: "关闭",
		}, function(index){
			layer.msg('关闭成功！',{icon: 6,time:1000});
		});
	});
	/*启用单一商品提示*/
	$(".tsj-btn").on("click", function(){
		layer.alert('亲，您确定将该原料重新启用吗？', {
			icon: 3,
			resize: false, //禁止拉伸
			title: "启用",
		}, function(index){
			layer.msg('启用成功！',{icon: 6,time:1000});
		});
	});
	
	/*弹出编辑原料*/
	$('.details-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '添加原料',
			area : ['460px' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'detailsMaterial.html',
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
			content: 'recycleMaterial.html',
		});
	});
});