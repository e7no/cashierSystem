/*
* @description: 自定义模板
* @author: will
* @update: will (2017-02-22 11:10)
* @version: v1.0
*/
$(function(){
	$(".template-btn").click(function(){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.layer.msg('恭喜你，模板修改成功！',{icon: 6,time:1500});
	})
})