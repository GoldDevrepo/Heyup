<?php

$common->adminAccess();
$document->setTitle('Transactions List');
$breadcrumb = $common->breadcrumb(array(
    array('text' => 'Home', 'href' => HTTP_ADMIN),
    array('text' => 'Transactions List', 'href' => $common->pageUrl('transactions/index', true)),
        ));

$page['title'] = 'Transactions List';

$filter_string = '';
$filter_name = '';
$filter_itunes_product = '';
$filter_description = '';
$filter_email = '';
$filter_amount = '';
$filter_created = '';

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
if (isset($request->get['filter_itunes_product'])) {
    $filter_itunes_product = $request->get['filter_itunes_product'];
    $filter_string .= '&filter_itunes_product=' . urlencode($filter_itunes_product);
    $filter_sql .= " AND itunes_product LIKE '%" . $filter_itunes_product . "%'";
}
if (isset($request->get['filter_description'])) {
    $filter_description = $request->get['filter_description'];
    $filter_string .= '&filter_description=' . urlencode($filter_description);
    $filter_sql .= " AND description LIKE '%" . $filter_description . "%'";
}
if (isset($request->get['filter_email'])) {
    $filter_email = $request->get['filter_email'];
    $filter_string .= '&filter_email=' . urlencode($filter_email);
    $filter_sql .= " AND email LIKE '%" . $filter_email . "%'";
}
if (isset($request->get['filter_amount'])) {
    $filter_amount = $request->get['filter_amount'];
    $filter_string .= '&filter_amount=' . urlencode($filter_amount);
    $filter_sql .= " AND amount LIKE '%" . $filter_amount . "%'";
}
if (isset($request->get['filter_created'])) {
    $filter_created = $request->get['filter_created'];
    $filter_string .= '&filter_created=' . urlencode($filter_created);
    $filter_sql .= " AND ( created BETWEEN  '" . $filter_created . "' AND '" . $filter_created . " 23:59:59' ) ";
}

$results = array();

//$query_count = "SELECT id from transactions t group by t.user_id, t.time_stamp";
//
//$result_ids = array();
//
//$rs_ids = $db->query($query_count);
//$result_ids = $rs_ids->rows;

$joining = " LEFT JOIN " . DB_PREFIX . "users u on u.id = t.user_id ";
$fields = "t.id as id, u.name as name, t.itunes_product, t.description, u.email, t.amount, t.created";
$statement = DB_PREFIX . "transactions t " . $joining . " WHERE 1=1 AND t.id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p')) " . $filter_sql;
$sql = "SELECT " . $fields . " FROM " . $statement . $sql_order;
$sql .=" LIMIT " . $startpoint . " , " . $limit;

//echo $sql;
//$rs = $db->query($sql);
//$results = $rs->rows;
?>