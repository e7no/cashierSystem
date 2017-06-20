/*
* @description: 编辑商品js
* @author: will
* @update: will (2017-03-16 15:40)
* @version: v1.0
*/
$(function(){
	/*表单调用*/
	layui.use('form', function(){
		var form = layui.form();
	});
	
	$('.article-button').on("click", function(){
		var name = $("#goods-name").val();
		var category = $("#goods-category").val();
		var unit = $("#goods-unit").val();
		var pur_price = $("#pur-price").val();
		var sy_switch = $("#sy-switch").siblings().hasClass("layui-form-onswitch");
		var sy_price = $("#sy-price").val();
		var sc_switch = $("#sc-switch").siblings().hasClass("layui-form-onswitch");
		var sc_price = $("#sc-price").val();
		var jf_switch = $("#jf-switch").siblings().hasClass("layui-form-onswitch");
		var jf_price = $("#jf-price").val();
		if (name == "") {
			layer.msg('请输入商品名称！',{time:1500});
		}
		else if(category == 0){
			layer.msg('请选择商品分类！',{time:1500});
		}
		else if(unit == 0) {
			layer.msg('请选择商品单位！',{time:1500});
		}
		else if(pur_price == ""){
			layer.msg('请输入商品进货价！',{time:1500});
		}
		else if(isNaN(pur_price) || pur_price < 0) {
			layer.msg('请输入正确的商品进货价！',{time:1500});
		}
		else if(sy_switch == true && sy_price == ""){
			layer.msg('请输入的商品售价！',{time:1500});
		}
		else if(sy_switch == true && isNaN(sy_price) || sy_price < 0) {
			layer.msg('请输入正确的价格！',{time:1500});
		}
		else if(sc_switch == true && sc_price == ""){
			layer.msg('请输入商品在商城售卖的价格！',{time:1500});
		}
		else if(sc_switch == true && isNaN(sc_price) || sc_price < 0) {
			layer.msg('请输入正确的价格！',{time:1500});
		}
		else if(sc_switch == true && sc_price == ""){
			layer.msg('请输入商品在商城售卖的价格！',{time:1500});
		}
		else if(sc_switch == true && isNaN(sc_price) || sc_price < 0) {
			layer.msg('请输入正确的价格！',{time:1500});
		}
		else{
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
		}
	})
})