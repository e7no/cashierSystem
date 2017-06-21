<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-门店进销存</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
</head>
<body>
	<div class="wrapper">
		<div class="content">
			<div class="wboxform">
				<form class="layui-form">
					<div class="layui-form-item">
						<div class="layui-inline">
					    	<label class="layui-form-label">门店</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input">
							    	<option value="0">请选择...</option>
                                    <option value="1">汇汇生活品牌店</option>
                                    <option value="2">汇生活茶话室</option>
                                    <option value="3">汇生活购物中心</option>
                                    <option value="4">汇生活便利店</option>
                                    <option value="5">汇生活美食馆</option>
                                    <option value="6">汇生活休闲吧</option>
                                </select>
					    	</div>
					   </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" id="logmin" placeholder="请选择开始时间"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" id="logmax" placeholder="请选择结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>门店进销存</h5>
					<div class="ibox-tools">
						<a class="btn-green" href="javascript:;">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table  class="layui-table" style="min-width: 2500px;">
							<thead>
								<tr class="text-c">
									<th width="7%">时间</th>
									<th class="text-l">门店名称</th>
									<th width="6%">商品类别</th>
									<th class="text-l" width="6%">商品名称</th>
									<th width="5%">期初库存</th>
									<th width="5%">期初金额</th>
									<th width="5%">入库数量</th>
									<th width="5%">入库金额</th>
									<th width="5%">出库数量</th>
									<th width="5%">出库金额</th>
									<th width="5%">销售数量</th>
									<th width="5%">销售金额</th>
									<th width="4%">报废数量</th>
									<th width="5%">报废金额</th>
									<th width="4%">盘点数量</th>
									<th width="3%">盈亏数量</th>
									<th width="4%">盈亏金额</th>
									<th width="4%">期末数量</th>
									<th width="5%">期末金额</th>
									<th width="3%">售罄率</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c">
									<td>2017-03-03 12:00:00</td>
									<td class="text-l">汇汇生活品牌店</td>
									<td>酒水</td>
									<td class="text-l">稻花香米酒</td>
									<td>80</td>
									<td>50.00</td>
									<td>20</td>
									<td>20.00</td>
									<td>20</td>
									<td>20.00</td>
									<td>20</td>
									<td>20.00</td>
									<td>20</td>
									<td>20.00</td>
									<td>20</td>
									<td>20</td>
									<td>20.00</td>
									<td>20</td>
									<td>20.00</td>
									<td>30%</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="page-list ng-isolate-scope" conf="paginationConf">
						<div class="page-total">
							 每页
							<select class="ng-pristine ng-untouched ng-valid ng-not-empty">
								<option label="5" value="number:5" selected="selected">5</option>
								<option label="10" value="number:10">10</option>
								<option label="20" value="number:20">20</option>
							</select>
							/共<strong class="ng-binding">32</strong>条
						</div>
						<ul class="pagination">
							<li class="disabled"><span>«</span></li>
							<li class="ng-scope active"><span class="ng-binding">1</span></li>
							<li class="ng-scope"><span class="ng-binding">2</span></li>
							<li class="ng-scope"><span class="ng-binding">3</span></li>
							<li class="ng-scope"><span class="ng-binding">4</span></li>
							<li class="ng-scope"><span class="ng-binding">5</span></li>
							<li class="ng-scope"><span class="ng-binding">6</span></li>
							<li class="ng-scope"><span class="ng-binding">7</span></li>
							<li><span>»</span></li>
						</ul>
						<div class="no-items ng-hide">
							暂无数据
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>