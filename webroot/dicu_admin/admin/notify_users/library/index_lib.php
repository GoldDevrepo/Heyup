<?php

$common->adminAccess();
$document->setTitle('Push Sender');
$breadcrumb = $common->breadcrumb(array(
    array('text' => 'Home', 'href' => HTTP_ADMIN),
    array('text' => 'Push Sender', 'href' => $common->pageUrl('notify_users/index', true)),
        ));

$page['title'] = 'Push Sender';

$filter_string = '';
$filter_name = '';
$filter_email = '';
$filter_mobile_no = '';
$filter_created = '';
$filter_status = '';
$filter_country = '';
$filter_device_name = '';

//sorting starts
$order_by = '&order=asc';
$order_class = '';
$order_paging = '';
if (isset($request->get['order'])) {
    $ord = ($request->get['order'] == 'asc') ? 'desc' : 'asc';
    $order_class = 'class="' . $ord . '"';
    $order_by = '&order=' . $ord;
    $order_paging = '&order=' . $request->get['order'];
}
$page_no = '';
if (isset($request->get['page'])) {
    $page_no = '&page=' . $request->get['page'];
}
$sort_by = '';
if (isset($request->get['sort'])) {
    $sort_by = '&sort=' . $request->get['sort'];
}
//sorting ends
//pagination starts
$page = (int) (!isset($request->get["page"]) ? 1 : $request->get["page"]);
$limit = 20;
$startpoint = ($page * $limit) - $limit;

//order conditions
$sql_order = " order by id desc ";
if (isset($request->get['order'])) {
    $sql_order = " order by " . $request->get['sort'] . " " . $request->get['order'] . " ";
}

//filters
$filter_sql = '';

if (isset($request->get['filter_name'])) {
    $filter_name = $request->get['filter_name'];
    $filter_string .= '&filter_name=' . urlencode($filter_name);
    $filter_sql .= " AND u.name LIKE '%" . $filter_name . "%'";
}
if (isset($request->get['filter_email'])) {
    $filter_email = $request->get['filter_email'];
    $filter_string .= '&filter_email=' . urlencode($filter_email);
    $filter_sql .= " AND email LIKE '%" . $filter_email . "%'";
}
if (isset($request->get['filter_mobile_no'])) {
    $filter_mobile_no = $request->get['filter_mobile_no'];
    $filter_string .= '&filter_mobile_no=' . urlencode($filter_mobile_no);
    $filter_sql .= " AND mobile_no LIKE '%" . $filter_mobile_no . "%'";
}
if (isset($request->get['filter_status'])) {
    $filter_status = $request->get['filter_status'];
    $filter_string .= '&filter_status=' . urlencode($filter_status);
    $filter_sql .= " AND status = '" . $filter_status . "'";
}
if (isset($request->get['filter_county'])) {
    $filter_country = $request->get['filter_country'];
    $filter_string .= '&filter_country=' . urlencode($filter_country);
    $filter_sql .= " AND country = '" . $filter_country . "'";
}
if (isset($request->get['filter_device_name'])) {
    $filter_device_name = $request->get['filter_device_name'];
    $filter_string .= '&filter_device_name=' . urlencode($filter_device_name);
    $filter_sql .= " AND d.device_id = '" . $filter_device_name . "'";
}
if (isset($request->get['filter_created'])) {
    $filter_created = $request->get['filter_created'];
    $filter_string .= '&filter_created=' . urlencode($filter_created);
    $filter_sql .= " AND ( created BETWEEN  '" . $filter_created . "' AND '" . $filter_created . " 23:59:59' ) ";
}

$results = array();

$joining = " LEFT JOIN " . DB_PREFIX . "device d on d.device_id = u.device_id ";
$fields = "d.name as device_name, u.id as id, u.name as name, "
        . "u.profile_img, u.email, u.mobile_no, "
        . "u.created, u.status, "
        . "(SELECT c.name FROM country c WHERE (c.iso_code_2=u.country OR iso_code_3=u.country) LIMIT 1) AS country";
$statement = DB_PREFIX . "users u " . $joining . " WHERE 1=1 AND u.status=1 " . $filter_sql;
$sql = "SELECT " . $fields . " FROM " . $statement . $sql_order;
$sql .=" LIMIT " . $startpoint . " , " . $limit;


$rs = $db->query($sql);
$results = $rs->rows;


//delete record starts
if ($request->server['REQUEST_METHOD'] == 'POST') {
    if ($sys->isPost('selected')) {
        $ids = $request->post['selected'];
       
        foreach ($ids as $id) {
            //send push
            
            $sql2 = "SELECT * FROM " . DB_PREFIX . "device_tokens WHERE user_id='" . (int) $id . "'";
            $rss = $db->query($sql2);
            $rs_res = $rss->rows;
if($rs_res){
    
}
        }
        $common->addAlert('success', 'Successfully Sent.');
        $sys->redirect('index.php');
    }
}
//delete record ends
?>
