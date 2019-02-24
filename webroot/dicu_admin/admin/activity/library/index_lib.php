<?php
	$common->adminAccess();
	$document->setTitle('Activity List');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Activity List','href'=>$common->pageUrl('activity/index',true)),
	));
	
	$page['title']	= 'Activity List';
	
	$filter_string = '';
	$filter_name = '';
	$filter_activity_type = '';
	$filter_description = '';
	$filter_email = '';
	$filter_whom = '';
	$filter_created = '';
	
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
	$limit = 20;
	$startpoint = ($page * $limit) - $limit;
	
	//order conditions
	$sql_order = " order by id desc ";
	if(isset($request->get['order'])){
		$sql_order = " order by ". $request->get['sort'] ." ". $request->get['order'] ." ";
	}
	
	//filters
	$filter_sql = '';
	
	if(isset($request->get['filter_name'])){
		$filter_name = $request->get['filter_name'];
		$filter_string .= '&filter_name='.urlencode($filter_name);
		$filter_sql .= " AND u.name LIKE '%". $filter_name ."%'";
	}
	if(isset($request->get['filter_whom'])){
		$filter_whom = $request->get['filter_whom'];
		$filter_string .= '&filter_whom='.urlencode($filter_whom);
		$filter_sql .= " AND u2.name LIKE '%". $filter_whom ."%'";
	}
	if(isset($request->get['filter_activity_type'])){
		$filter_activity_type = $request->get['filter_activity_type'];
		$filter_string .= '&filter_activity_type='.urlencode($filter_activity_type);
		$filter_sql .= " AND activity_type LIKE '%". $filter_activity_type ."%'";
	}
	if(isset($request->get['filter_description'])){
		$filter_description = $request->get['filter_description'];
		$filter_string .= '&filter_description='.urlencode($filter_description);
		$filter_sql .= " AND description LIKE '%". $filter_description ."%'";
	}


	$results = array();
	
	$joining = " LEFT JOIN ". DB_PREFIX ."users u on u.id = t.who ";
	$joining .= " LEFT JOIN ". DB_PREFIX ."users u2 on u2.id = t.whom ";

	$fields = "t.id as id, u.name as name, t.activity_type, t.description, u2.name as whom, t.created, t.modified";
	$statement = DB_PREFIX."activities t ". $joining ." WHERE 1=1 ".$filter_sql;
	$sql = "SELECT ". $fields ." FROM ".$statement.$sql_order;
	$sql .=" LIMIT ".$startpoint." , ".$limit;
	

	$rs = $db->query($sql);
	$results = $rs->rows;
	
?>
