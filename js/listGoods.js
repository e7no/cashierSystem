/*
* @description: 商品列表js
* @author: will
* @update: will (2017-02-22 11:10)
* @version: v1.0
*/
$(function(){
	/*删除选中的商品提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定删除选中的商品吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	/*删除单一商品提示*/
	$(".goods-delbtn").on("click", function(){
		layer.alert('亲，您确定删除该商品吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	/*下架选中的商品提示*/
	$(".xj-btn").on("click", function(){
		layer.alert('亲，您确定下架选中的商品吗？', {
			icon: 5,
			resize: false, //禁止拉伸
			title: "下架",
		}, function(index){
			layer.msg('下架成功！',{icon: 6,time:1000});
		});
	});
	/*下架单一商品提示*/
	$(".txj-btn").on("click", function(){
		layer.alert('亲，您确定下架该商品吗？', {
			icon: 5,
			resize: false, //禁止拉伸
			title: "下架",
		}, function(index){
			layer.msg('下架成功！',{icon: 6,time:1000});
		});
	});
	/*上架单一商品提示*/
	$(".tsj-btn").on("click", function(){
		layer.alert('亲，您确定将该商品重新上架吗？', {
			icon: 3,
			resize: false, //禁止拉伸
			title: "上架",
		}, function(index){
			layer.msg('上架成功！',{icon: 6,time:1000});
		});
	});
	
	/*弹出编辑商品*/
	$('.details-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '商品编辑',
			area : ['645px' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'detailsGoods.html',
		});
	});
	
	/*弹出商品价格调控*/
	$('.price-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '商品价格调控',
			area : ['100%' , '100%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'priceControl.html',
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
			content: 'recycleListGoods.html',
		});
	});
});