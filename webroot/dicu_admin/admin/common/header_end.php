</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
<div class="navbar-header">
<?php if($common->checkAdminLogin()){ ?>
<a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
<?php } ?>
<a href="<?php echo HTTP_SERVER; ?>" class="navbar-brand"><img src="image/logo.png" alt="<?php echo WEBSITE_NAME; ?>" title="<?php echo WEBSITE_NAME; ?>" /></a></div>

<?php if($common->checkAdminLogin()) { ?>
<ul class="nav pull-right">
<!-- <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger pull-left">1</span> <i class="fa fa-bell fa-lg"></i></a>
	<ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
		<li class="dropdown-header">Orders</li>
		<li><a href="http://local.urocko.com/admin/index.php?route=sale/order&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_order_status=2" style="display: block; overflow: auto;"><span class="label label-warning pull-right">0</span>Pending</a></li>
		<li><a href="http://local.urocko.com/admin/index.php?route=sale/order&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_order_status=5"><span class="label label-success pull-right">0</span>Completed</a></li>
		<li><a href="http://local.urocko.com/admin/index.php?route=sale/return&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7"><span class="label label-danger pull-right">0</span>Returns</a></li>
		<li class="divider"></li>
		<li class="dropdown-header">Customers</li>
		<li><a href="http://local.urocko.com/admin/index.php?route=report/customer_online&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7"><span class="label label-success pull-right">0</span>Customers Online</a></li>
		<li><a href="http://local.urocko.com/admin/index.php?route=sale/customer&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_approved=0"><span class="label label-danger pull-right">0</span>Pending approval</a></li>
		<li class="divider"></li>
		<li class="dropdown-header">Products</li>
		<li><a href="http://local.urocko.com/admin/index.php?route=catalog/product&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_quantity=0"><span class="label label-danger pull-right">1</span>Out of stock</a></li>
		<li><a href="http://local.urocko.com/admin/index.php?route=catalog/review&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_status=0"><span class="label label-danger pull-right">0</span>Reviews</a></li>
		<li class="divider"></li>
		<li class="dropdown-header">Affiliates</li>
		<li><a href="http://local.urocko.com/admin/index.php?route=marketing/affiliate&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7&amp;filter_approved=1"><span class="label label-danger pull-right">0</span>Pending approval</a></li>
	</ul>
</li>
-->
<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring fa-lg"></i></a>
	<ul class="dropdown-menu dropdown-menu-right">
		<li class="dropdown-header">Stores <i class="fa fa-shopping-cart"></i></li>
		<li><a href="<?php echo HTTP_SERVER; ?>" target="_blank">Your Store</a></li>
		<li class="divider"></li>
	</ul>
</li>
<li><a href="<?php echo HTTP_ADMIN; ?>logout.php"><span class="hidden-xs hidden-sm hidden-md">Logout</span> <i class="fa fa-sign-out fa-lg"></i></a></li>
</ul>
<?php } ?>
	
  </header>
<?php require_once('header_menu.php'); ?>