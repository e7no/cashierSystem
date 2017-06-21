/*
* @description: 折扣-回收站js
* @author: will
* @update: will (2017-02-22 11:10)
* @version: v1.0
*/
$(function(){
	/*从回收站恢复数据*/
	$(".restore-btn").on("click", function(){
		layer.alert('确认恢复该折扣项目吗？', {
			icon: 3,
			title: "折扣恢复",
			resize: false, //禁止拉伸
		}, function(index){
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恭喜你，添恢复成功！',{icon: 6,time:1500});
		});
	});
})