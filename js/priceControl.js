/*
* @description: 商品价格调控js
* @author: will
* @update: will (2017-03-28 15:40)
* @version: v1.0
*/
$(function(){
	$('.price-btn').on("click", function(){
		var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恭喜你，修改成功！',{icon: 6,time:1500});
	})
})