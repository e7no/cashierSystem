/*
* @description: 仓库设置js
* @author: will
* @update: will (2017-02-23 15:10)
* @version: v1.0
*/
$(function(){
	/*删除提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定把我删了吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
});