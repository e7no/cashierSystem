/*
* @description: 成品入库js
* @author: will
* @update: will (2017-03-24 19:00)
* @version: v1.0
*/
$(function(){
	/*删除选择商品*/
	$(".del-btn").on("click", function(){
	    layer.alert('亲，您确定删除选中的商品吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
			}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	})
	
	/*弹出编辑商品*/
	$('.add-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '添加商品',
			area : ['70%' , '84%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			content: 'addGoodsStorage.html',
		});
	});
	/*添加成功关闭弹窗*/
	$(".put-btn").on("click", function(){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.layer.msg('恭喜你，入库成功！',{icon: 6,time:1500});
	})
})
