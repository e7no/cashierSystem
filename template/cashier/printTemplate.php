<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-自定义模板</title>
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
				<div class="wbox-content print-template">
					<div class="pt-content">
						<div class="pt-left">
							<fieldset class="layui-elem-field">
								<legend>模板设置</legend>
								<form class="layui-field-box">
									<ul>
										<li><label><input type="checkbox" /><span>标题</span></label></li>
										<li><label><input type="checkbox" /><span>门店名称</span></label></li>
										<li><label><input type="checkbox" /><span>桌台</span></label></li>
										<li><label><input type="checkbox" /><span>人数</span></label></li>
										<li><label><input type="checkbox" /><span>时间</span></label></li>
										<li><label><input type="checkbox" /><span>操作员</span></label></li>
										<li><label><input type="checkbox" /><span>品项</span></label></li>
										<li><label><input type="checkbox" /><span>数量</span></label></li>
										<li><label><input type="checkbox" /><span>单项</span></label></li>
										<li><label><input type="checkbox" /><span>小计</span></label></li>
										<li><label><input type="checkbox" /><span>合计</span></label></li>
									</ul>
								</form>
							</fieldset>
						</div>
						<div class="pt-right">
							<fieldset class="layui-elem-field">
								<legend>模板预览</legend>
								<div class="layui-field-box">
									<div class="preview-template">
										<h2>消费单</h2>
										<div class="preview-box1">门店名称：汇汇生活品牌店</div>
										<div class="preview-box">
											<div class="preview-l">桌台：1</div>
											<div class="preview-r">人数：10</div>
										</div>
										<div class="preview-box1">单号：5669799794</div>
										<div class="preview-box">
											<div class="preview-l">时间：2017-03-31</div>
											<div class="preview-r">操作员：will</div>
										</div>
										<ul class="list">
											<li>
												<h4>品项</h4>
												<span>数量</span>
												<span>单价</span>
												<span>确认</span>
											</li>
											<li>
												<h4>鱼香肉丝</h4>
												<span>1</span>
												<span>30</span>
												<span><i></i></span>
											</li>
										</ul>
										<div class="preview-box1">合计：&#12288;1&#12288;&#12288;50</div>
										<div class="preview-box">
											<div class="preview-l">折扣：    -10</div>
											<div class="preview-r">折让：     -10</div>
										</div>
										<div class="preview-box">
											<div class="preview-l">优惠券：   -10</div>
											<div class="preview-r">合计优惠： -30 </div>
										</div>
										<div class="preview-box">
											<div class="preview-l">应付：      20</div>
										</div>
										<div class="preview-box1">
											结算：现金&#12288;100<br />
											&#12288;&#12288;&#12288;扫码付&#12288;100<br />
											&#12288;&#12288;&#12288;會員卡&#12288;100<br />
											&#12288;&#12288;&#12288;银联卡&#12288;100
										</div>
										<div class="preview-box">
											<div class="preview-l">合计实付：</div>
											<div class="preview-r">找零：</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="layui-form-item">
						<input type="button" class="layui-btn layui-btn-small layui-btn-normal template-btn" value="保存" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
	<script type="text/javascript" src="../../js/printTemplate.js"></script>
</body>
</html>