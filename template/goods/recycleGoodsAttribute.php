<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-商品属性-回收站</title>
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
					    	<label class="layui-form-label">属性类型</label>
					    	<div class="layui-input-inline">
					    		<select class="layui-input">
							        <option value="0">请选择...</option>
							        <option value="1">商品属性</option>
							        <option value="2">销售属性</option>
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
					<h5>商品属性</h5>
					<div class="ibox-tools">
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table class="layui-table" style="min-width: 600px;">
							<thead>
								<tr class="text-c">
									<th class="text-l" width="24%">属性类型</th>
									<th width="24%">属性类别</th>
									<th width="20%">属性名称</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c">
									<td class="text-l">商品属性</td>
									<td>口味</td>
									<td>微辣</td>
									<td>
										<a class="btn-blue restore-btn" href="javascript:;">恢复</a>
									</td>
								</tr>
								<tr class="text-c">
									<td class="text-l">销售属性</td>
									<td>分量</td>
									<td>小份</td>
									<td>
										<a class="btn-blue restore-btn" href="javascript:;">恢复</a>
									</td>
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
	<!--添加-->
	<div class="popup add-popup">
		<form class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">属性类型</label>
				<div class="layui-input-inline" style="width: 210px;">
					<select class="layui-input" id="attr-type">
						<option value="0">请选择...</option>
						<option value="1">商品属性</option>
						<option value="2">销售属性</option>
					</select>
				</div>
			</div>
			<div class="layui-form-item" style="margin-top: 10px;">
				<label class="layui-form-label">属性类别</label>
				<div class="layui-input-inline" style="width: 210px;">
					<input placeholder="请输入属性类别" class="layui-input" id="attr-class" type="text">
				</div>
			</div>
			<div class="layui-form-item" style="margin-top: 10px;">
				<label class="layui-form-label">属性名称</label>
				<div class="layui-input-inline" style="width: 210px;">
					<input placeholder="请输入属性名称" class="layui-input" id="attr-name" type="text">
				</div>
			</div>
			<div class="layui-form-item" style="margin-top: 10px;">
				<label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
				<input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" value="保存">
				<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
			</div>
		</form>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/recycleGoodsAttribute.js"></script>
</body>
</html>