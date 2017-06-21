<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-订单汇总</title>
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
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" id="logmin" placeholder="请选择开始时间"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" id="logmax" placeholder="请选择结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">消费门店</label>
					    	<div class="layui-input-inline">
					    		<select class="layui-input">
							        <option value="0">请选择...</option>
							        <option value="1">汇汇生活品牌店</option>
							        <option value="2">桂香美食</option>
							    </select>
					    	</div>
					    </div>
					    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>订单汇总</h5>
					<div class="ibox-tools">
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table  class="layui-table" style="min-width: 1200px;">
							<thead>
								<tr class="text-c">
									<th class="text-l">门店名称</th>
									<th width="10%">订单总量</th>
									<th width="12%">消费金额</th>
									<th width="12%">优惠金额</th>
									<th width="12%">实付金额</th>
									<th width="10%">打包费</th>
									<th width="10%">配送费</th>
									<th width="13%">总金额</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c">
									<td class="text-l">汇汇生活品牌店</td>
									<td>852</td>
									<td>8588425.00</td>
									<td>1000000.00</td>
									<td>7588425.00</td>
									<td>3000.00</td>
									<td>7000.00</td>
									<td>7598425.00</td>
								</tr>
								<tr class="text-c">
									<td class="text-l">汇汇生活品牌店</td>
									<td>852</td>
									<td>8588425.00</td>
									<td>1000000.00</td>
									<td>7588425.00</td>
									<td>3000.00</td>
									<td>7000.00</td>
									<td>7598425.00</td>
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