<?php
include('Common/check.php');
$stoType=$_SESSION['stoType'];
$manageEmp=$_SESSION['authManageEmp'];
?>
<!DOCTYPE html>
<php>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="renderer" content="webkit">
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<title>商家云后台管理系统</title>
		<meta name="keywords" content="汇汇生活-让实体店生意火起来">
		<meta name="description" content="汇汇生活-世界都在用">
		<link rel="bookmark" href="favicon.ico" >
		<link rel="shortcut icon" href="favicon.ico" />
		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/html5.js"></script>
		<script type="text/javascript" src="js/respond.min.js"></script>
		<script type="text/javascript" src="js/PIE_IE678.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/common.css">
	</head>
<body class="fixed-sidebar full-height-layout">
	<div id="wrapper">
		<nav id="navbar-default" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse">
                <div class="logo">
                    <img src="img/logo.png">  
                    <h1>商家云后台管理系统</h1>
                </div>
                <div class="logo-element"><img src="img/logo2.png"></div>
				<ul id="side-menu">
					<li>
						<a href="javascript:;">
							<i class="iconfont will-icon1"></i>
							<span>门店管理</span>
						</a>
						<ul>
							<?php if($stoType!=1){?>
							<li><a class="will-menuItem" href="template/store/storeInfo.php">门店信息</a></li>
							<?php }?>
							<?php if($stoType==1){?>
							<li><a class="will-menuItem" href="template/store/storeManage.php">分店管理</a></li>
							<?php }?>
						</ul>
					</li>
					<?php if($manageEmp!=1 || $stoType==1){?>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-huiyuanguanli"></i>
							<span>员工管理</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/staff/staffManage.php">员工管理</a></li>
<!--							<li><a class="will-menuItem" href="">岗位管理</a></li>-->
						</ul>
					</li>
					<?php }?>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-shangpin"></i>
							<span>商品管理</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/goods/unitManage.php">单位管理</a></li>
							<li><a class="will-menuItem" href="template/goods/goodsCategory.php">商品分类</a></li>
							<li><a class="will-menuItem" href="template/goods/listGoods.php">商品列表</a></li>
							<li><a class="will-menuItem" href="template/goods/goodsZuofa.php">做法管理</a></li>
						</ul>
					</li>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-yuanliao"></i>
							<span>原料管理</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/material/materialCategory.php">原料分类</a></li>
							<li><a class="will-menuItem" href="template/material/listMaterial.php">原料列表</a></li>
						</ul>
					</li>
					<li>
                		<a href="javascript:;">
                			<i class="iconfont will-ico3"></i>
                			<span>库存统计</span>
                		</a>
                		<ul>
                			<li><a class="will-menuItem" href="template/inventory/listMaterialInventory.php">原料库存</a></li>
                			<li><a class="will-menuItem" href="template/inventory/listGoodsInventory.php">商品库存</a></li>
                		</ul>
                	</li>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-jinxiaocun"></i>
							<span>进销存管理</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/psi/listMaterialStorage.php">原料入库</a></li>
                			<li><a class="will-menuItem" href="template/psi/listMaterialReceive.php">原料领用</a></li>
                			<li><a class="will-menuItem" href="template/psi/listMaterialScrap.php">原料报废</a></li>
                			<li><a class="will-menuItem" href="template/psi/listMaterialCheck.php">原料盘点</a></li>
                			<li><a class="will-menuItem" href="template/psi/listGoodsStorage.php">商品入库</a></li>
                			<li><a class="will-menuItem" href="template/psi/listGoodsReceive.php">商品出库</a></li>
                			<li><a class="will-menuItem" href="template/psi/listGoodsScrap.php">商品报废</a></li>
                			<li><a class="will-menuItem" href="template/psi/listGoodsCheck.php">商品盘点</a></li>
						</ul>
					</li>
					<?php if($stoType!=1){?>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-shouyintai"></i>
							<span>收银设置</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/cashier/counterManage.php">桌台管理</a></li>
							<li><a class="will-menuItem" href="template/cashier/basicSetup.php">基本设置</a></li>
							<li><a class="will-menuItem" href="template/cashier/printerManage.php">打印机管理</a></li>
							<li><a class="will-menuItem" href="template/cashier/listKlb.php">客流宝管理</a></li>
							<li><a class="will-menuItem" href="template/cashier/viceScreen.php">副屏管理</a></li>
						</ul>
					</li>
					<?php }?>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-huiyuanguanli1"></i>
							<span>会员管理</span>
						</a>
						<ul class="collapse">
							<li><a class="will-menuItem" href="template/member/listMember.php">会员列表</a></li>
							<li><a class="will-menuItem" href="template/member/listCzxf.php">充值消费记录</a></li>
							<li><a class="will-menuItem" href="template/member/listConsume.php">消费列表</a></li>
							<li><a class="will-menuItem" href="template/member/listIntegral.php">积分兑换</a></li>
							<?php if($stoType==1){?>
							<li><a class="will-menuItem" href="template/member/vipCard.php">会员卡设置</a></li>
							<?php }?>
						</ul>
					</li>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-caiwuguanli"></i>
							<span>财务管理</span>
						</a>
						<ul>
<!--                			<li><a class="will-menuItem" href="template/finance/listIncomeSpending.php">收支汇总</a></li>-->
                			<li><a class="will-menuItem" href="template/finance/withdrawal.php">余额提现</a></li>
                			<li><a class="will-menuItem" href="template/finance/listOtherFiles.php">其他收支</a></li>
                		</ul>
					</li>
					<?php if($stoType!=1){?>
					<li>
						<a href="javascript:;">
							<i class="iconfont will-yunying"></i>
							<span>营销管理</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/marketing/listDiscount.php">折扣</a></li>
							<li><a class="will-menuItem" href="template/marketing/listZherang.php">折让</a></li>
							<li><a class="will-menuItem" href="template/marketing/listVouchers.php">优惠券</a></li>
							<li><a class="will-menuItem" href="template/marketing/listMiandan.php">免单</a></li>
							<li><a class="will-menuItem" href="template/marketing/listZengson.php">赠送</a></li>
						</ul>
					</li>
					<?php }?>
<!--					<li>-->
<!--						<a href="javascript:;">-->
<!--							<i class="iconfont will-mendian"></i>-->
<!--							<span>商城管理</span>-->
<!--						</a>-->
<!--						<ul>-->
<!--							<li><a class="will-menuItem" href="template/shop/listOrder.php">订单管理</a></li>-->
<!--							<li><a class="will-menuItem" href="template/shop/totalOrder.php">订单汇总</a></li>-->
<!--							<li><a class="will-menuItem" href="template/shop/totalSale.php">销售统计</a></li>-->
<!--						</ul>-->
<!--					</li>-->
					<li>
						<a href="javascript:;">
							<i class="iconfont will-1395biaogemianban"></i>
							<span>报表中心</span>
						</a>
						<ul>
							<li><a class="will-menuItem" href="template/table/detailsPaymentTabel.php" data-index="38">收支报表</a></li>
							<li><a class="will-menuItem" href="template/table/orderSumTabel.php" data-index="39">订单明细</a></li>
                			<li><a class="will-menuItem" href="template/table/listJhbTabel.php" data-index="40">交换班记录</a></li>
                			<li><a class="will-menuItem" href="template/table/goodsSaleTabel.php" data-index="41">商品销售排行</a></li>
							<li><a class="will-menuItem" href="template/table/materialPsitTabel.php">原料进销存</a></li>
<!--                			<li><a class="will-menuItem" href="template/table/storePsitTabel.php" data-index="42">门店进销存</a></li>-->
<!--                			<li><a class="will-menuItem" href="template/table/dayReportTabel.php" data-index="43">门店日结报表</a></li>-->
<!--                			<li><a class="will-menuItem" href="template/table/monthlyStatementTabel.php" data-index="44">门店月结报表</a></li>-->
							<li><a class="will-menuItem" href="template/table/dataAnalysisTabel.php">客流分析</a></li>
							<li><a class="will-menuItem" href="template/table/dataValueTabel.php">客流价值分析</a></li>
						</ul>
					</li>
				</ul>
            </div>
        </nav>
        <div id="right">
            <div class="row top">
                <nav class="navbar navbar-static-top">
                	<a class="navbar-minimalize btn btn-primary" href="#"><i class="iconfont will-liebiao1"></i></a>
                	<div class="welcome"><span><?php echo $_SESSION['stoName'];?></span>欢迎您登录商家云后台管理系统！</div>
                	<a class="will-menuItem pwd-btn" href="changePassword.php"><i class="iconfont will-xiugaimima"></i>修改密码</a>
<!--                	<div class="msg-btn">-->
<!--                		<a class="will-menuItem" href="changePassword.php">-->
<!--	                		<i class="iconfont will-tongzhi"></i>-->
<!--	                		<span>最新消息</span>-->
<!--                		</a>-->
<!--                		<em class="label-danger">28</em>-->
<!--                	</div>-->
                </nav>
            </div>
            <div class="row content-tabs">
                <button class="roll-nav roll-left"><i class="iconfont will-houtui"></i></button>
                <nav class="page-tabs will-menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active will-menuTab" data-id="welcome.php">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right will-tabRight"><i class="iconfont will-qianjin"></i></button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown will-tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="will-tabCloseAll"><a>关闭全部选项卡</a></li>
                        <li class="will-tabCloseOther"><a>关闭其他选项卡</a></li>
                    </ul>
                </div>
                <a href="Controller/login/logout.php" class="roll-nav roll-right will-tabExit"><i class="iconfont will-tuichu"></i>退出</a>
            </div>
            <div id="main" class="row willContent">
               	<iframe class="will-iframe" name="iframe" width="100%" height="100%" src="welcome.php" data-id="welcome.php" frameborder="0" seamless></iframe>
            </div>
            <div class="footer">
                <div class="pull-right">
                    Copyright © 2016-2017 <a href="http://www.huihuishenghuo.com" target="_blank">汇汇生活</a>
                </div>
            </div>
        </div>
	</div>
	<div id="browser_ie">
		<div class="brower_info">
			<div class="notice_info">
				<p>你的浏览器版本过低，可能导致网站不能正常访问！<BR>为了你能正常使用网站功能，请使用这些浏览器。</p>
			</div>
			<div class="browser_list">
				<span>
					<a  href="http://www.google.cn/intl/zh-CN/chrome/browser/" target="_blank">
						<img src="img/Chrome.png" />Chrome
					</a>
				</span>
				<span>
					<a href="http://www.firefox.com.cn/" target="_blank">
						<img src="img/Firefox.png" />Firefox
					</a>
				</span>
				<span>
					<a href="https://www.apple.com/cn/safari/" target="_blank">
						<img src="img/Safari.png" />Safari
					</a>
				</span>
				<span>
					<a href="http://rj.baidu.com/soft/detail/23360.html?ald" target="_blank">
						<img src="img/IE.png" />IE10及以上
					</a>
				</span>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/metisMenu/jquery.metisMenu.js"></script>
	<script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="js/layer/layer.min.js"></script>
	<script type="text/javascript" src="js/contabs.js"></script>
	<script type="text/javascript" src="js/will.js"></script>
	<script>
		if(navigator.appName == "Microsoft Internet Explorer"&&parseInt(navigator.appVersion.split(";")[1].replace(/[ ]/g, "").replace("MSIE",""))<10){
			$("#browser_ie").show();
			$("#wrapper").hide();
		}
	</script>
</body>
</php>