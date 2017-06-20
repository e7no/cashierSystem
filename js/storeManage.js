/*
* @description: 分店管理js
* @author: will
* @update: will (2017-02-23 10:06)
* @version: v1.0
*/
$(function(){
	/*弹出新建（绑定）门店*/
	$('.new-btn').on('click', function(){
		layer.open({
			type: 1,
			title: "添加门店",//标题
			anim: '2',
			area: ['310px', '100%'],//宽高
			shadeClose: true, //点击遮罩关闭
			offset: ['0', '0'],
			resize: false, //禁止拉伸
			content: $(".bind-popup"),//也可将html写在此处
		});
	});
	
	function isPhoneNo(phone) {
		var m_phone = /^[1][34578][0-9]{9}$/;
		return m_phone.test(phone);
	}
	
	/*判断、绑定门店成功，关闭弹层并提示*/
	$(".bangding-btn").on("click", function(){
		var num = $("#num").val();
		var coding = $("#coding").val();
		var phone = $("#phone").val();
		var pwd = $("#password").val();
		if (coding == "") {
			layer.msg('请输入门店编码！',{time:1500});
		}
		else{
			layer.closeAll('page'); //关闭弹层
			layer.msg('恭喜你，绑定成功！',{icon: 6,time:1000});
		}
	});
	
	/*功能修改*/
	$(".function-btn").on("click", function(){
		layer.open({
			type: 1,
			title: "修改分店权限",//标题
			anim: '2',
			area: ['340px', '250px'],//宽高
			shadeClose: true, //点击遮罩关闭
			resize: false, //禁止拉伸
			content: $(".fendian-change"),//也可将html写在此处
		});
	});
	
	/*表单调用*/
	layui.use('form', function(){
	  var form = layui.form();
	});
	
	$(".change-btn").on("click", function() {
		layer.closeAll('page'); //关闭弹层
		layer.msg('恭喜你，分店权限修改成功！',{icon: 6,time:1000});
	});
	
	/*绑定门店失败，关闭弹层并提示重新绑定*/
	/*
	$(".bangding-btn").on("click", function(){
		layer.closeAll('page'); //关闭弹层
		layer.msg('非常抱歉，信息校验失败，请重新绑定！',{icon: 5,time:2000});
	});
	*/
	
	/*删除提示*/
	$(".del-btn").on("click", function(){
		layer.alert('亲，您确定解绑本店吗？', {
			icon: 5,
			title: "解绑",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('解绑成功！',{icon: 6,time:1000});
		});
	});
	
	/*重新开启*/
	$(".open-btn").on("click", function(){
		layer.alert('亲，您确重新开启本店吗？', {
			icon: 3,
			title: "重新开启",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('开启成功！',{icon: 6,time:1000});
		});
	});
	
	/*关闭店铺即关闭店铺已开启的功能*/
	$(".close-btn").on("click", function(){
		layer.alert('亲，您确关闭本店吗？', {
			icon: 5,
			title: "关闭",
			resize: false, //禁止拉伸
		}, function(index){
			layer.msg('关闭成功！',{icon: 6,time:1000});
		});
	});
	/*点击更多*/
	$(".btn-green").on("click", function(){
		var count = $('#coding').size();
		var level='';
		var codingparent = $('#codingparent').html();
		for(var i =count; i<count+5;i++){
			level +='<div class="layui-form-item" style="margin-top: 10px;">';
				level +='<label class="layui-form-label">门店编码</label>';
				level +='<div class="layui-input-inline" style="width: 200px;">';
				level +='<input type="text" class="layui-input" id="coding" placeholder="请输入门店编码">';
				level +='</div>';
			level +='</div>';	
		}
		$('#codingparent').html(codingparent+level);
	});
})
