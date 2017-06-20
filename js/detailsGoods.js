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
	
	$(".add-tab").click(function(){
		var len=$("table.detail-table tr").length;
		if(len < 5){
			$("table").append(
				'<tr class="text-c" id='+len+'>'+
				'<td><input type="text" class="layui-input" id="goods-ge'+len+'" placeholder="规格"></td>'+
				'<td><input type="text" class="layui-input" id="pur-price'+len+'" placeholder="进价"></td>'+
				'<td><input type="text" class="layui-input" id="sy-price'+len+'" placeholder="售价"></td>'+
				'<td><input type="text" class="layui-input" id="sc-price'+len+'" placeholder="商城价"></td>'+
				'<td><input type="text" class="layui-input" id="jf-price'+len+'" placeholder="积分价"></td>'+
				'</tr>'
			);
		}	
	});
	$(".del-tab").click(function(){
		var len=$("table tr").length;
		if(len > 2){
			$("tr[id='"+(len-1)+"']").remove(); 
		}
	});
	
	
	$('.article-button').on("click", function(){
		var name = $("#goods-name").val();
		var category = $("#goods-category").val();
		var unit = $("#goods-unit").val();
		
		var goods_ge = $("#goods-ge").val();
		var goods_ge3 = $("#goods-ge3").val();
		var goods_ge4 = $("#goods-ge4").val();
		
		var sy_switch = $("#sy-switch").siblings().hasClass("layui-form-onswitch");
		var sy_price = $("#sy-price").val();
		var sy_price3 = $("#sy-price3").val();
		var sy_price4 = $("#sy-price4").val();
		
		var sc_switch = $("#sc-switch").siblings().hasClass("layui-form-onswitch");
		var sc_price = $("#sc-price").val();
		var sc_price3 = $("#sc-price3").val();
		var sc_price4 = $("#sc-price4").val();
		
		var jf_switch = $("#jf-switch").siblings().hasClass("layui-form-onswitch");
		var jf_price = $("#jf-price").val();
		var jf_price3 = $("#jf-price3").val();
		var jf_price4 = $("#jf-price4").val();
		
		if (name == "") {
			layer.msg('请输入商品名称！',{time:1500});
		}
		else if(category == 0){
			layer.msg('请选择商品分类！',{time:1500});
		}
		else if(unit == 0) {
			layer.msg('请选择商品单位！',{time:1500});
		}
		else if (goods_ge == "" || goods_ge3 == "" || goods_ge4 == "") {
			layer.msg('请输入商品规格！',{time:1500});
		}
		else if(sy_switch == true && sy_price == ""){
			layer.msg('请输入该商品的售价！',{time:1500});
		}
		else if(sy_switch == true && sy_price3 == ""){
			layer.msg('请输入该商品的售价！',{time:1500});
		}
		else if(sy_switch == true && sy_price4 == ""){
			layer.msg('请输入该商品的售价！',{time:1500});
		}
		else if(sc_switch == true && sc_price == ""){
			layer.msg('请输入该商品的商城价！',{time:1500});
		}
		else if(sc_switch == true && sc_price3 == ""){
			layer.msg('请输入该商品的商城价！',{time:1500});
		}
		else if(sc_switch == true && sc_price4 == ""){
			layer.msg('请输入该商品的商城价！',{time:1500});
		}
		else if(jf_switch == true && jf_price == ""){
			layer.msg('请输入该商品的积分价！',{time:1500});
		}
		else if(jf_switch == true && jf_price3 ==""){
			layer.msg('请输入该商品的积分价！',{time:1500});
		}
		else if(jf_switch == true && jf_price4 == ""){
			layer.msg('请输入该商品的积分价！',{time:1500});
		}
		else{
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
		}
	})
})