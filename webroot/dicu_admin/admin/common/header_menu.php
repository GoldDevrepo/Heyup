<?php if($common->checkAdminLogin()){ ?>
<nav id="column-left"><div id="profile">
  <div>
    <h4><?php echo ucwords($session->data['admin']['first_name'].' '.$session->data['admin']['last_name']); ?></h4>
    <small>Administrator</small></div>
</div>
<ul id="menu">
  <li id="dashboard"><a href="<?php $common->pageUrl('dashboard'); ?>"><i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span></a></li>
	
  <li id="sale"><a class="parent"><i class="fa fa-shopping-cart fa-fw"></i> <span>Users</span></a>
    <ul>
      <li><a href="<?php $common->pageUrl('users/index'); ?>">All Users</a></li>
      <li><a href="<?php $common->pageUrl('transactions/index'); ?>">Transactions</a></li>
<li><a href="<?php $common->pageUrl('activity/index'); ?>">Activities</a></li>
<li><a href="<?php $common->pageUrl('notify_users/index'); ?>">Push Sender</a></li>
    </ul>
  </li>
  <li><a class="parent"><i class="fa fa-share-alt fa-fw"></i> <span>Marketing</span></a>
    <ul>
      <li><a href="javascript:void(0);">Coupons</a></li>
      <li><a href="javascript:void(0);">Subscribers</a></li>
    </ul>
  </li>
  <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span>System</span></a>
    <ul>
      <li><a href="javascript:void(0);">Settings</a></li>
      <li><a href="<?php $common->pageUrl('admin_users/index'); ?>">Admin Users</a></li>
		</ul>
  </li>
  <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span>Reports</span></a>
    <ul>
      <li><a class="parent">Sales</a>
        <ul>
          <li><a href="javascript:void(0);">Orders</a></li>
        </ul>
      </li>
    </ul>
  </li>
</ul>
</nav>
<?php } ?>
