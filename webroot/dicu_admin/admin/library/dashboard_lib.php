<?php

$common->adminAccess();
$document->setTitle('Dashboard');
$breadcrumb = $common->breadcrumb(array(
    array('text' => 'Home', 'href' => HTTP_ADMIN),
    array('text' => 'Dashboard', 'href' => HTTP_ADMIN . 'dashboard.php'),
        ));
$page['title'] = 'Dashboard';

$total_users = 0;
$total_users_month = 0;
$total_sales = 0.00;
$total_sales_month = 0.00;

$date_month_start = date('Y-m-') . "01 00:00:00";
$date_month_end = date('Y-m-d') . " 23:59:59";

$sql_users = "SELECT count(id) AS total FROM " . DB_PREFIX . "users";
$rs_users = $db->query($sql_users);
$total_users = $rs_users->row['total'];


$sql_users = "SELECT count(id) AS total FROM " . DB_PREFIX . "users WHERE created>='" . $date_month_start . "' AND created<='" . $date_month_end . "'";
$rs_users = $db->query($sql_users);
$total_users_month = $rs_users->row['total'];

//$sql_sales = "SELECT SUM(amount) AS total FROM " . DB_PREFIX . "transactions WHERE id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p'))";
//string(189) "SELECT SUM(amount) AS total FROM transactions WHERE id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p'))"
//var_dump($sql_sales);
//$rs_sales = $db->query($sql_sales);
//$total_sales = $rs_sales->row['total'];


//$sql_sales = "SELECT sum(amount) AS total FROM " . DB_PREFIX . "transactions WHERE created>='" . $date_month_start . "' AND created<='" . $date_month_end . "' AND id IN (SELECT t2.id from transactions t2  WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p'))";
//string(260) "SELECT sum(amount) AS total FROM transactions WHERE created>='2017-01-01 00:00:00' AND created<='2017-01-19 23:59:59' AND id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p'))"
//var_dump($sql_sales);
//echo $sql_sales;
//$rs_sales = $db->query($sql_sales);
//$total_sales_month = $rs_sales->row['total'];


// users per month for graph 
$sql_users = "SELECT monthname(created) as month, year(created) as year, count(id) AS total FROM " . DB_PREFIX . "users group by month(created), year(created) order by created DESC limit 12";
$rs_users = $db->query($sql_users);

$users = array();
for ($index = count($rs_users->rows) - 1; $index >= 0; $index--) {
    $users[] = $rs_users->rows[$index];
}

// leading country per month for graph 
//SELECT c.`name`, COUNT(c.`name`) as count FROM country c LEFT JOIN users u ON c.iso_code_2 = u.country or c.iso_code_3 = u.country GROUP BY c.`name` ORDER BY count DESC
//$sql_users = "SELECT monthname(created) as month, year(created) as year, count(id) AS total FROM " . DB_PREFIX . "users group by month(created), year(created) order by created DESC limit 12";
$sql_leading_countries = "SELECT c.`name`, COUNT(c.`name`) as count FROM " . DB_PREFIX . "country c LEFT JOIN users u ON c.iso_code_2 = u.country or c.iso_code_3 = u.country GROUP BY c.`name` ORDER BY count DESC limit 12";
//echo $sql_leading_countries;
$rs_leading_countries = $db->query($sql_leading_countries);

$leading_countries = array();
for ($index = count($rs_leading_countries->rows) - 1; $index >= 0; $index--) {
    $leading_countries[] = $rs_leading_countries->rows[$index];
}

// sales per month for graph
$sql_sales = "SELECT monthname(created) as month, year(created) as year, sum(amount) AS total FROM " . DB_PREFIX . "transactions WHERE id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p')) group by month(created), year(created) order by created DESC limit 12";
//string(311) "SELECT monthname(created) as month, year(created) as year, sum(amount) AS total FROM transactions WHERE id IN (SELECT t2.id from transactions t2 WHERE t2.credit > 0 group by t2.user_id, t2.amount, DATE_FORMAT(t2.created,'%b %d %Y %h:%i %p')) group by month(created), year(created) order by created DESC limit 12"
//var_dump($sql_sales);
//$rs_sales = $db->query($sql_sales);
//$sales = array();
//for ($index = count($rs_sales->rows) - 1; $index >= 0; $index--) {
 //   $sales[] = $rs_sales->rows[$index];
//}