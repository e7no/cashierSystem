/*
* @description: 添加硬件js
* @author: will
* @update: will (2017-03-16 15:40)
* @version: v1.0
*/
$(function(){
	
	$(".add-hbtn").click(function(){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
	})
	
	/*弹出自定义模板*/
	$('.zdy-btn').on('click', function(){
		layer.open({
		type: 2,
			title: '自定义模板',
			area : ['600px' , '100%'],
			anim: '2',
			resize: false,
			move: false,
			shadeClose: true,
			offset: ['0', '0'],
			content: 'printTemplate.html',
		});
	});
})