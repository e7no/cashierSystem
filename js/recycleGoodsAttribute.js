/*
* @description: 商品属性js
* @author: will
* @update: will (2017-03-27 12:00)
* @version: v1.0
*/
$(function(){
	/*从回收站恢复数据*/
	$(".restore-btn").on("click", function(){
		layer.alert('确认恢复该商品属性吗？', {
			icon: 3,
			title: "商品属性恢复",
			resize: false, //禁止拉伸
		},  function(index){
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恢复成功！',{icon: 6,time:1500});
		});
	});
})