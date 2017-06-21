/*
* @description: 商品属性js
* @author: will
* @update: will (2017-03-27 12:00)
* @version: v1.0
*/
$(function(){
	/*添加属性*/
	$('.add-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "添加商品属性",//标题
			area: ['310px', '230px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".add-popup"),//也可将html写在此处
		});
	});
	/*添加成功，关闭弹层并提示*/
	$(".add-submit").on("click", function(){
		var attr_type = $("#attr-type").val();
		var attr_class = $("#attr-class").val();
		var attr_name = $("#attr-name").val();
		if(attr_type == 0) {
			layer.msg('请选择属性类型！',{time:1500});
		}
		else if(attr_class == "") {
			layer.msg('请输入属性类别！',{time:1500});
		}
		else if (attr_name == "") {
			layer.msg('请输入属性名称！',{time:1500});
		}else {
			layer.closeAll('page'); //关闭弹层
			layer.msg('恭喜你，添加成功！',{icon: 6,time:1000});
		}
	});
	
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
			content: 'recycleGoodsAttribute.html',
		});
	});
})
