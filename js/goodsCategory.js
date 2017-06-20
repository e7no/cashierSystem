/*
* @description: 商品类别js
* @author: will
* @update: will (2017-02-22 10:10)
* @version: v1.0
*/
$(function(){
	/*新增分类*/
	$('.level-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "新增分类",//标题
			area: ['350px', '220px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".popup-Level"),//也可将html写在此处
		});
	});
	
	/*判断、添加成功提示并关闭弹层*/
	$(".Level-submit").on("click", function(){
		var levelName1 = $("#levelName").val();
		var levelNum1 = $("#levelNum").val();
		if (levelName1 == "") {
			layer.msg('请输入分类名称！',{time:1500});
		}else if (levelNum1 == "") {
			layer.msg('请输入排序编号！',{time:1500});
		}else {
			layer.closeAll('page'); //关闭弹层
			layer.msg('恭喜你，分类添加成功！',{icon: 6,time:1000});
		}
	})
	
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
			content: 'recycleGoodsCategory.html',
		});
	});
});