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
			title: "添加商品做法",//标题
			area: ['275px', '150px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".add-popup"),//也可将html写在此处
		});
	});
	
	
	/*表单调用*/
	layui.use('form', function(){
		var form = layui.form();
	});
	
	/*添加成功，关闭弹层并提示*/
	$(".zuofa-submit").on("click", function(){
		var attr_name = $("#zuofa-name").val();
		if(attr_name == 0) {
			layer.msg('请输入做法名称！',{time:1500});
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
	
	$(".list-zuofa ul").find("li").click(function(){
		if ($(this).find("input[type=radio]").is(":checked")) {
			$(this).siblings('li').removeClass('active');
			$(this).addClass("active");
		}
	})
})
