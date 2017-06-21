/*
* @description: 副屏设置
* @author: will
* @update: will (2017-02-24 16:30)
* @version: v1.0
*/
$(function(){
	/*弹出购买明细*/
	$('.news-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '添加副屏',
			area : ['460px' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'addVice.html',
		});
	});
	
	/*删除提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定删除该副屏广告吗？', {
			icon: 5,
			title: "删除",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('删除成功！',{icon: 6,time:1000});
		});
	});
	
	/*副屏设置*/
	$('.set-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "副屏设置",//标题
			area: ['320px', '200px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".set-popup"),//也可将html写在此处
		});
	});
	
	$(".sp-btn").on("click", function(){
		layer.closeAll('page'); //关闭弹层
		layer.msg('恭喜你，设置成功！',{icon: 6,time:1000});
	})
	
	layui.use('form', function(){
		var form = layui.form();
	});
})
