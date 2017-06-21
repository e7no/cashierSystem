/*
* @description: 编辑折扣
* @author: will
* @update: will (2017-03-16 15:40)
* @version: v1.0
*/
$(function(){
	$(".del-tab").click(function(){
		var len=$("table tr").length;
		if(len > 2){
			$("tr[id='"+(len-1)+"']").remove(); 
		}
	});
	
	
	$('.details-button').on("click", function(){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
		parent.layer.msg('恭喜你，添加成功！',{icon: 6,time:1500});
	})
})