<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-商品入库</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
</head>
<body>
	<div class="wrapper">
		<div class="content">
			<div class="wbox">
				<div class="wbox-title">
					<h5>支出项目</h5>
					<div class="ibox-tools">
						<a class="btn-green" href="javascript:;">修改</a>
						<a class="btn-red del-btn" href="javascript:;">删除项目</a>
						<a class="btn-blue put-btn" href="javascript:;">录入</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<form>
						<div class="con-table">
							<table class="layui-table" style="min-width: 1000px;">
								<thead>
									<tr class="text-c">
										<th width="6%"><input type="checkbox" /></th>
										<th class="text-l">项目名称</th>
										<th width="12%">费用</th>
										<th width="40%">备注</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-c">
										<td><input type="checkbox" /></td>
										<td class="text-l">3月份水费</td>
										<td><input type="text" class="egs-text" placeholder="支出费用" /></td>
										<td><input type="text" class="egs-text" placeholder="支出备注" /></td>
									</tr>
									<tr class="text-c">
										<td><input type="checkbox" /></td>
										<td class="text-l">3月份电费</td>
										<td><input type="text" class="egs-text" placeholder="支出费用" /></td>
										<td><input type="text" class="egs-text" placeholder="支出备注" /></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="layui-form-item">
							<input type="button" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="入库">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/editOtherFiles.js"></script>
</body>
</html>