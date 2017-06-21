/*
* @description: 编辑原料js
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
		var name = $("#material-name").val();
		var category = $("#material-category").val();
		var unit = $("#material-unit").val();
		var cgbz_price = $("#cgbz-price").val();
		var cgzg_price = $("#cgzg-price").val();
		if (name == "") {
			layer.msg('请输入原料名称！',{time:1500});
		}
		else if(category == 0){
			layer.msg('请选择原料分类！',{time:1500});
		}
		else if(unit == 0) {
			layer.msg('请选择原料单位！',{time:1500});
		}
		else if(cgbz_price == ""){
			layer.msg('请输入采购标准价！',{time:1500});
		}
		else if(isNaN(cgbz_price) || cgbz_price < 0) {
			layer.msg('请输入正确的采购标准价！',{time:1500});
		}
		else if(cgzg_price == ""){
			layer.msg('请输入采购最高价！',{time:1500});
		}
		else if(isNaN(cgzg_price) || cgzg_price < 0) {
			layer.msg('请输入正确的采购最高价！',{time:1500});
		}
		else{
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
			parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
		}
	})
})