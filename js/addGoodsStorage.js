/*
* @description: 成品入库-添加商品js
* @author: will
* @update: will (2017-03-24 19:00)
* @version: v1.0
*/
$(function(){
	/*添加成功关闭弹窗*/
	$(".add-submit").on("click", function(){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.layer.open({
		type: 2,
			title: '新增单据',
			area : ['100%' , '100%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			content: 'editGoodsStorage.html',
		});
		parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
	})
})
