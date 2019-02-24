<?php
	$common->adminAccess();
	$document->setTitle('Admin User List');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Admin User List','href'=>$common->pageUrl('admin_users/index',true)),
	));
	
	$page['title']	= 'Admin User List';
	
	$filter_string = '';
	$filter_username = '';
	$filter_first_name = '';
	$filter_last_name = '';
	$filter_email = '';
	$filter_phone = '';
	$filter_date_added = '';
	$filter_status = '';
	
	//sorting starts
	$order_by = '&order=asc';
	$order_class = '';
	$order_paging = '';
	if(isset($request->get['order'])){
		$ord = ($request->get['order']=='asc')?'desc':'asc';
		$order_class = 'class="'.$ord.'"';
		$order_by = '&order='.$ord;
		$order_paging = '&order='.$request->get['order'];
	}
	$page_no = '';
	if(isset($request->get['page'])){
		$page_no = '&page='.$request->get['page'];
	}
	$sort_by = '';
	if(isset($request->get['sort'])){
		$sort_by = '&sort='.$request->get['sort'];
	}
	//sorting ends
	
	//pagination starts
	$page = (int) (!isset($request->get["page"]) ? 1 : $request->get["page"]);
	$limit = 10;
	$startpoint = ($page * $limit) - $limit;
	
	//order conditions
	$sql_order = " order by admin_id desc ";
	if(isset($request->get['order'])){
		$sql_order = " order by ". $request->get['sort'] ." ". $request->get['order'] ." ";
	}
	
	//filters
	$filter_sql = '';
	
	if(isset($request->get['filter_username'])){
		$filter_username = $request->get['filter_username'];
		$filter_string .= '&filter_username='.urlencode($filter_username);
		$filter_sql .= " AND username LIKE '%". $filter_username ."%'";
	}
	if(isset($request->get['filter_first_name'])){
		$filter_first_name = $request->get['filter_first_name'];
		$filter_string .= '&filter_first_name='.urlencode($filter_first_name);
		$filter_sql .= " AND first_name LIKE '%". $filter_first_name ."%'";
	}
	if(isset($request->get['filter_last_name'])){
		$filter_last_name = $request->get['filter_last_name'];
		$filter_string .= '&filter_last_name='.urlencode($filter_last_name);
		$filter_sql .= " AND last_name LIKE '%". $filter_last_name ."%'";
	}
	if(isset($request->get['filter_email'])){
		$filter_email = $request->get['filter_email'];
		$filter_string .= '&filter_email='.urlencode($filter_email);
		$filter_sql .= " AND email LIKE '%". $filter_email ."%'";
	}
	if(isset($request->get['filter_phone'])){
		$filter_phone = $request->get['filter_phone'];
		$filter_string .= '&filter_phone='.urlencode($filter_phone);
		$filter_sql .= " AND phone LIKE '%". $filter_phone ."%'";
	}
	if(isset($request->get['filter_status'])){
		$filter_status = $request->get['filter_status'];
		$filter_string .= '&filter_status='.urlencode($filter_status);
		$filter_sql .= " AND status = '". $filter_status ."'";
	}
	if(isset($request->get['filter_date_added'])){
		$filter_date_added = $request->get['filter_date_added'];
		$filter_string .= '&filter_date_added='.urlencode($filter_date_added);
		$filter_sql .= " AND ( date_added BETWEEN  '". $filter_date_added ."' AND '". $filter_date_added ." 23:59:59' ) ";
	}

	$results = array();
	
	$statement = DB_PREFIX."admin_user WHERE 1=1 ".$filter_sql;
	$sql = "SELECT * FROM ".$statement.$sql_order;
	$sql .=" LIMIT ".$startpoint." , ".$limit;
	

	$rs = $db->query($sql);
	$results = $rs->rows;
	
	
	//delete record starts
	if ($request->server['REQUEST_METHOD'] == 'POST') {
		if($sys->isPost('selected')){
			$admin_ids = $request->post['selected'];
			foreach($admin_ids as $admin_id){
				$sql = "DELETE FROM ". DB_PREFIX ."admin_user WHERE admin_id='". (int)$admin_id ."'";
				$db->query($sql);
			}
			$common->addAlert('success', 'Successfully deleted.');
			$sys->redirect('index.php');
		}
	}
	//delete record ends
	
?>