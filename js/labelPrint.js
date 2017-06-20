/*
* @description: 标签打印
* @author: will
* @update: will (2017-03-16 15:40)
* @version: v1.0
*/
$(function(){
	/*打印提示*/
	$(".print-btn").on("click", function(){
		layer.alert('亲，您确定打印选中的商品标签吗？', {
			icon: 3,
			title: "标签打印",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('打印成功！',{icon: 6,time:1000});
		});
	});
})