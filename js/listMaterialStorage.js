/*
* @description: 原材料入库-新增单据js
* @author: will
* @update: will (2017-02-24 16:30)
* @version: v1.0
*/
$(function(){
	/*弹出编辑商品*/
	$('.news-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '新增单据',
			area : ['70%' , '100%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'addMaterialStorage.html',
		});
	});
	/*选项卡*/
	layui.use('element', function(){
		var element = layui.element();
	});
})
